<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

/** The contact form: emails the message to the site's contact address. Nothing is stored. */
class ContactController extends Controller
{
    public function send(Request $request): JsonResponse
    {
        // Bots fill in every field; people never see this one.
        if (trim((string) $request->input('website', '')) !== '') {
            return response()->json(['status' => 'sent']);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'max:254', 'email:rfc'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        try {
            Mail::to(config('site.contact_email'))->send(new ContactMessage(trim($data['name']), trim($data['email']), trim($data['message'])));
        } catch (Throwable $e) {
            Log::error('Contact form email failed', ['error' => $e->getMessage()]);

            return response()->json(['status' => 'failed'], 503);
        }

        return response()->json(['status' => 'sent']);
    }
}
