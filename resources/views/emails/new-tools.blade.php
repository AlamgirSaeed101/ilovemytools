@extends('emails.layout', ['preheader' => count($tools) === 1 ? $tools[0]['tagline'] : t('New free tools you can use right now.')])

@section('body')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="font-size:12px;font-weight:800;letter-spacing:1.6px;text-transform:uppercase;color:#2563eb;padding-bottom:6px;">{{ count($tools) > 1 ? t('New tools') : t('New tool') }}</td>
        </tr>
        <tr>
            <td style="font-size:24px;font-weight:800;letter-spacing:-0.4px;padding-bottom:10px;">
                {{ count($tools) === 1 ? t('We just added a new free tool') : t('We just added new free tools') }}
            </td>
        </tr>
        <tr>
            <td style="font-size:15px;line-height:1.6;color:#334155;padding-bottom:22px;">
                {{ t('Free, private and right in your browser - no sign up, no uploads, no watermarks.') }}
            </td>
        </tr>
        @foreach ($tools as $tool)
            <tr>
                <td style="padding-bottom:14px;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e8ef;border-radius:16px;">
                        <tr>
                            <td width="64" valign="top" style="padding:18px 0 18px 18px;">
                                <div style="width:44px;height:44px;border-radius:12px;background:{{ $tool['accent'] }};color:#ffffff;font-size:20px;font-weight:800;line-height:44px;text-align:center;">{{ mb_strtoupper(mb_substr($tool['name'], 0, 1)) }}</div>
                            </td>
                            <td valign="top" style="padding:18px 18px 18px 12px;">
                                <div style="font-size:17px;font-weight:800;padding-bottom:4px;">{{ $tool['name'] }}</div>
                                <div style="font-size:14px;line-height:1.55;color:#475569;padding-bottom:12px;">{{ $tool['tagline'] }}</div>
                                <a href="{{ $tool['url'] }}" style="display:inline-block;background:#16a34a;background-image:linear-gradient(135deg,#10b981,#16a34a);color:#ffffff;text-decoration:none;font-weight:700;font-size:14px;padding:10px 20px;border-radius:999px;">{{ t('Try it free') }} &rarr;</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endforeach
        <tr>
            <td align="center" style="padding-top:8px;">
                <a href="{{ $homeUrl }}" style="font-size:14px;font-weight:700;color:#2563eb;text-decoration:none;">{{ t('Browse all free tools') }} &rarr;</a>
            </td>
        </tr>
    </table>
@endsection

@section('footer')
    {{ t('You are receiving this because you subscribed to new tool announcements.') }}
    <a href="{{ $unsubscribeUrl }}" style="color:#64748b;">{{ t('Unsubscribe') }}</a>
@endsection
