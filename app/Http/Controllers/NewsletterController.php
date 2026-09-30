<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmSubscription;
use App\Models\Subscriber;
use App\Support\Locale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Newsletter: sign up (double opt-in), confirm and unsubscribe.
 *
 * Responses never reveal whether an address is already on the list.
 */
class NewsletterController extends Controller
{
    /** Minimum time between two confirmation emails to the same address. */
    private const RESEND_AFTER_MINUTES = 10;

    public function subscribe(Request $request): JsonResponse
    {
        // Bots fill in every field; people never see this one.
        if (trim((string) $request->input('website', '')) !== '') {
            return response()->json(['status' => 'pending']);
        }

        $data = $request->validate([
            'email' => ['required', 'string', 'max:254', 'email:rfc'],
            'locale' => ['nullable', 'string', 'max:8'],
        ]);

        $email = mb_strtolower(trim($data['email']));
        $locale = Locale::isSupported((string) ($data['locale'] ?? '')) ? $data['locale'] : Locale::default();

        $subscriber = Subscriber::firstOrNew(['email' => $email]);
        if ($subscriber->exists && $subscriber->status === Subscriber::CONFIRMED) {
            return response()->json(['status' => 'pending']);
        }

        if ($subscriber->exists && $subscriber->status === Subscriber::PENDING
            && $subscriber->confirmation_sent_at?->gt(now()->subMinutes(self::RESEND_AFTER_MINUTES))) {
            return response()->json(['status' => 'pending']);
        }

        $subscriber->fill([
            'locale' => $locale,
            'status' => Subscriber::PENDING,
            'token' => $subscriber->token ?: Subscriber::newToken(),
            'unsubscribed_at' => null,
            'confirmation_sent_at' => now(),
        ])->save();

        try {
            Mail::to($subscriber->email)->send(new ConfirmSubscription($subscriber));
        } catch (Throwable $e) {
            // The address is saved; the confirmation can be re-sent by signing up again.
            Log::error('Newsletter confirmation email failed', ['error' => $e->getMessage()]);
        }

        return response()->json(['status' => 'pending']);
    }

    public function confirm(string $token): RedirectResponse
    {
        $subscriber = Subscriber::where('token', $token)->first();
        if ($subscriber === null) {
            return $this->backHome(Locale::default(), 'invalid');
        }

        if ($subscriber->status !== Subscriber::CONFIRMED) {
            $subscriber->forceFill(['status' => Subscriber::CONFIRMED, 'confirmed_at' => now(), 'unsubscribed_at' => null])->save();
        }

        return $this->backHome($subscriber->locale, 'confirmed');
    }

    /** Link in the email: show the "unsubscribe?" prompt (a GET must never unsubscribe, link scanners follow links). */
    public function unsubscribePrompt(string $token): RedirectResponse
    {
        $subscriber = Subscriber::where('token', $token)->first();

        return $subscriber === null
            ? $this->backHome(Locale::default(), 'invalid')
            : $this->backHome($subscriber->locale, 'unsubscribe', $token);
    }

    /** The prompt's button (JSON) and the mail app's one-click unsubscribe (RFC 8058) both POST here. */
    public function unsubscribe(Request $request, ?string $token = null): JsonResponse|Response
    {
        $token = $token ?? (string) $request->input('token', '');
        $subscriber = $token !== '' ? Subscriber::where('token', $token)->first() : null;

        if ($subscriber !== null && $subscriber->status !== Subscriber::UNSUBSCRIBED) {
            $subscriber->forceFill(['status' => Subscriber::UNSUBSCRIBED, 'unsubscribed_at' => now()])->save();
        }

        return $request->expectsJson()
            ? response()->json(['status' => $subscriber === null ? 'invalid' : 'unsubscribed'], $subscriber === null ? 404 : 200)
            : response('', $subscriber === null ? 404 : 200);
    }

    private function backHome(string $locale, string $state, ?string $token = null): RedirectResponse
    {
        $query = http_build_query(array_filter(['newsletter' => $state, 'token' => $token]));

        return redirect()->to(Locale::path('/', $locale).'?'.$query);
    }
}
