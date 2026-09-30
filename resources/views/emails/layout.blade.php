{{-- Shared email layout: table-based with inline styles so it renders in Gmail, Outlook and Apple Mail. --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>{{ config('site.name') }}</title>
</head>
<body style="margin:0;padding:0;background:#eef4ff;font-family:'Plus Jakarta Sans',-apple-system,'Segoe UI',Roboto,Arial,sans-serif;color:#0f172a;">
    @isset($preheader)
        <div style="display:none;max-height:0;overflow:hidden;opacity:0;">{{ $preheader }}</div>
    @endisset
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef4ff;padding:32px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;">
                    <tr>
                        <td align="center" style="padding:0 0 20px;">
                            <a href="{{ url('/') }}" style="text-decoration:none;font-size:26px;font-weight:800;letter-spacing:-0.5px;color:#0f172a;">
                                I <span style="color:#e11d48;">&#9829;</span> <span style="color:#f97316;">Tools</span>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#ffffff;border:1px solid #e5e8ef;border-radius:20px;padding:32px 28px;">
                            @yield('body')
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:20px 12px 0;font-size:12px;line-height:1.6;color:#64748b;">
                            @yield('footer')
                            <br>{{ config('site.name') }} · <a href="{{ url('/') }}" style="color:#64748b;">{{ preg_replace('#^https?://#', '', rtrim(url('/'), '/')) }}</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
