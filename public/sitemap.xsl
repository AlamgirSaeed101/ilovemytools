<?xml version="1.0" encoding="UTF-8"?>
<!-- Renders sitemap.xml as a readable page in browsers. Search engines ignore this file. -->
<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:s="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xhtml="http://www.w3.org/1999/xhtml"
    exclude-result-prefixes="s xhtml">
    <xsl:output method="html" encoding="UTF-8" indent="yes"/>
    <xsl:template match="/">
        <html lang="en">
            <head>
                <meta charset="utf-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1"/>
                <meta name="robots" content="noindex"/>
                <title>XML Sitemap - ILoveTools</title>
                <style>
                    body { margin: 0; font: 15px/1.5 system-ui, -apple-system, "Segoe UI", sans-serif; color: #0f172a; background: #f8fafc; }
                    main { max-width: 1100px; margin: 0 auto; padding: 32px 16px; }
                    h1 { margin: 0 0 6px; font-size: 26px; }
                    p { margin: 0 0 20px; color: #475569; }
                    a { color: #2563eb; text-decoration: none; overflow-wrap: anywhere; }
                    a:hover { text-decoration: underline; }
                    .wrap { overflow-x: auto; background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { padding: 10px 14px; text-align: left; border-bottom: 1px solid #e2e8f0; vertical-align: top; }
                    th { background: #eff6ff; font-size: 13px; text-transform: uppercase; letter-spacing: .04em; color: #1e3a8a; }
                    tr:last-child td { border-bottom: 0; }
                    .muted { color: #64748b; white-space: nowrap; }
                </style>
            </head>
            <body>
                <main>
                    <h1>XML Sitemap</h1>
                    <p>
                        This sitemap lists <strong><xsl:value-of select="count(s:urlset/s:url)"/></strong> pages for search engines.
                        <a href="/">Back to ILoveTools</a>
                    </p>
                    <div class="wrap">
                        <table>
                            <tr><th>Page</th><th>Language versions</th><th>Last modified</th><th>Priority</th></tr>
                            <xsl:for-each select="s:urlset/s:url">
                                <tr>
                                    <td><a href="{s:loc}"><xsl:value-of select="s:loc"/></a></td>
                                    <td class="muted"><xsl:value-of select="count(xhtml:link) - 1"/></td>
                                    <td class="muted"><xsl:value-of select="s:lastmod"/></td>
                                    <td class="muted"><xsl:value-of select="s:priority"/></td>
                                </tr>
                            </xsl:for-each>
                        </table>
                    </div>
                </main>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
