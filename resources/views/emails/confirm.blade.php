@extends('emails.layout', ['preheader' => t('One click to confirm your subscription.')])

@section('body')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding-bottom:18px;">
                <div style="width:56px;height:56px;border-radius:16px;background:#2563eb;background-image:linear-gradient(135deg,#3b82f6,#1d4ed8);color:#ffffff;font-size:28px;line-height:56px;text-align:center;">&#9993;</div>
            </td>
        </tr>
        <tr>
            <td align="center" style="font-size:24px;font-weight:800;letter-spacing:-0.4px;padding-bottom:10px;">{{ t('Confirm your subscription') }}</td>
        </tr>
        <tr>
            <td align="center" style="font-size:15px;line-height:1.6;color:#334155;padding-bottom:24px;">
                {{ t('Thanks for signing up! Click the button below to confirm your email address. We will then send you one short email whenever we add a new free tool.') }}
            </td>
        </tr>
        <tr>
            <td align="center" style="padding-bottom:24px;">
                <a href="{{ $confirmUrl }}" style="display:inline-block;background:#16a34a;background-image:linear-gradient(135deg,#10b981,#16a34a);color:#ffffff;text-decoration:none;font-weight:700;font-size:15px;padding:14px 28px;border-radius:999px;">{{ t('Confirm my email') }}</a>
            </td>
        </tr>
        <tr>
            <td align="center" style="font-size:13px;line-height:1.6;color:#64748b;">
                {{ t('If you did not sign up, just ignore this email and you will not hear from us again.') }}
            </td>
        </tr>
    </table>
@endsection

@section('footer')
    {{ t('You received this email because someone entered this address in the newsletter form on our website.') }}
@endsection
