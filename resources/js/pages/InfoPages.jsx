import { Link } from 'react-router';
import Breadcrumbs from '../components/Breadcrumbs.jsx';
import CopyButton from '../components/CopyButton.jsx';
import Icon from '../components/Icon.jsx';
import { getSite } from '../lib/api.js';
import { formatDate, t, tr } from '../lib/i18n.js';
import { useMeta } from '../lib/meta.js';

function InfoPage({ page, path, children }) {
    const site = getSite();
    const meta = site.meta[page];
    // Legal and company pages are indexed in English only (see Seo::englishOnly()).
    useMeta({ ...meta, path, englishOnly: true }, site.url);
    const title = meta.title.replace(` | ${site.name}`, '');

    return (
        <div className="shell shell--narrow">
            <Breadcrumbs items={[{ name: title, to: path }]} />
            <article className="prose page-article">{children}</article>
        </div>
    );
}

function Email() {
    const { contactEmail } = getSite();
    return <a href={`mailto:${contactEmail}`}>{contactEmail}</a>;
}

function External({ href, children }) {
    return (
        <a href={href} rel="nofollow noopener noreferrer" target="_blank">
            {children}
        </a>
    );
}

export function About() {
    const site = getSite();
    const name = site.name;
    const items = [
        ['shield', 'Privacy first', 'Our tools process your files and text directly in your web browser. PDFs, images and documents never leave your device.'],
        ['gift', 'Free forever', 'Every tool is free with no account, no daily limit and no watermark. The site is supported by unobtrusive advertising.'],
        ['zap', 'Fast and simple', 'Each tool does one job well, loads quickly and works on phones, tablets and computers.'],
    ];
    return (
        <InfoPage page="about" path="/about">
            <h1>{t('About {name}', { name })}</h1>
            <p className="lead">
                {t('{name} is a free collection of simple, fast and private online tools. We built it because most “free” tools online are slow, covered in pop-ups, add watermarks, or quietly upload your files to their servers.', { name })}
            </p>
            <p>{t('{name} launched in {year}. Everything on the site is free to use and is paid for by advertising.', { name, year: site.founded })}</p>
            {site.founder && <p>{t('{name} was founded by {founder}.', { name, founder: site.founder })}</p>}

            {site.brandFaqs?.length > 0 && (
                <>
                    <h2>{name} at a glance</h2>
                    {site.brandFaqs.map((faq) => (
                        <div key={faq.q}>
                            <h3>{faq.q}</h3>
                            <p>{faq.a}</p>
                        </div>
                    ))}
                </>
            )}

            <div className="feature-list">
                {items.map(([icon, title, text]) => (
                    <div className="feature-item" key={title}>
                        <span className="icon-tile">
                            <Icon name={icon} />
                        </span>
                        <div>
                            <h2>{t(title)}</h2>
                            <p>{t(text)}</p>
                        </div>
                    </div>
                ))}
            </div>

            <h2>{t('How we build and test our tools')}</h2>
            <p>{t('Our tools are built on well-known open-source libraries, such as PDF.js from Mozilla and pdf-lib for PDFs, and run inside your browser.')}</p>
            <p>{t('Before every release, automated tests open every tool in every language and check real results, for example that a merged PDF has the right pages or that a compressed image is smaller.')}</p>
            <p>{t('Formulas and facts on our pages come from published standards and research, listed under “Sources” on each tool page.')}</p>

            <h2>{t('How to check that your files stay private')}</h2>
            <p>{t('Open your browser’s developer tools, choose the Network tab and use any tool: you will see that your file is never sent anywhere. The few tools that need to look something up online, such as the Broken Link Checker, say so clearly on the page.')}</p>

            <h2>{t('Our tools')}</h2>
            <p>
                {t('We currently offer {tools} free tools across {categories} categories, including a word counter, PDF merger, image compressor, QR code generator, calculators, games, timers and developer utilities, and we add new tools regularly.', {
                    tools: site.tools.length,
                    categories: site.categories.length,
                })}
            </p>

            <h2>{t('Corrections')}</h2>
            <p>{t('If you find a mistake in a result or on a page, please tell us and we will correct it. Each tool page shows when it was last updated.')}</p>

            <h2>{t('Get in touch')}</h2>
            <p>{tr('Have an idea for a new tool or found a bug? We would love to hear from you on our {link}.', { link: <Link to="/contact">{t('contact page')}</Link> })}</p>
        </InfoPage>
    );
}

export function Contact() {
    const { contactEmail } = getSite();
    return (
        <InfoPage page="contact" path="/contact">
            <h1>{t('Contact Us')}</h1>
            <p className="lead">{t('We read every message. Get in touch to:')}</p>
            <ul>
                <li>{t('Report a bug or a tool that is not working as expected')}</li>
                <li>{t('Suggest a new tool you would like us to build')}</li>
                <li>{t('Ask about advertising or partnerships')}</li>
                <li>{t('Send privacy or legal requests')}</li>
            </ul>

            <div className="contact-card">
                <span className="icon-tile icon-tile--lg">
                    <Icon name="mail" />
                </span>
                <div>
                    <p className="contact-card__label">{t('Email us at')}</p>
                    <p className="contact-card__email">
                        <Email />
                    </p>
                    <p className="contact-card__note">{t('We usually reply within 2 business days.')}</p>
                </div>
                <CopyButton text={contactEmail} label={t('Copy email')} className="btn btn--sm" />
            </div>

            <p>{t('When reporting a problem, please tell us which tool you used, your browser (for example Chrome or Safari) and your device, so we can fix it quickly.')}</p>
        </InfoPage>
    );
}

export function Privacy() {
    const site = getSite();
    const name = site.name;
    return (
        <InfoPage page="privacy" path="/privacy-policy">
            <h1>{t('Privacy Policy')}</h1>
            <p className="muted">{t('Last updated: {date}', { date: formatDate(site.legalUpdated) })}</p>

            <p>{t('This Privacy Policy explains how {name} (“we”, “us”) handles information when you use {url} (the “Site”). Please also read the section about advertising cookies below.', { name, url: site.url })}</p>

            <h2>{t('1. Files and text you use in our tools')}</h2>
            <p>{t('Our tools (for example the PDF, image and text tools) run entirely inside your web browser. The files, images and text you process are not uploaded to our servers, are not stored by us and are not visible to us. When you close the page, the data is gone.')}</p>
            <p>{t('The only exception is the “What Is My IP” tool, which shows you the IP address your browser used to reach our server. We display it back to you and do not store it in a database.')}</p>

            <h2>{t('2. Information collected automatically')}</h2>
            <p>{t('Like most websites, our web server may keep standard log files that include your IP address, browser type, pages visited and the date and time of the visit. These logs are used only for security, troubleshooting and preventing abuse, and are deleted regularly.')}</p>

            <p>{t('If you subscribe to our newsletter, we store your email address, your language and the date you signed up and confirmed, only to email you when we add new tools. We never share or sell it. Every email has a one-click unsubscribe link, and you can ask us to delete your address at any time.')}</p>

            <h2>{t('3. Cookies and local storage')}</h2>
            <p>{t('Cookies are small text files stored on your device. We do not set any cookies of our own. We use:')}</p>
            <ul>
                <li>{t('Local storage in your browser to remember your light/dark theme and recently used tools. This never leaves your device.')}</li>
                <li>{t('Analytics cookies (if enabled) such as Google Analytics, to understand how visitors use the Site in aggregate.')}</li>
                <li>{t('Advertising cookies used by Google and its partners to show ads, as described below.')}</li>
            </ul>

            <h2>{t('4. Advertising (Google AdSense)')}</h2>
            <p>{t('We use Google AdSense to show advertisements. Third-party vendors, including Google, use cookies to serve ads based on your prior visits to this Site or other websites.')}</p>
            <p>{t("Google's use of advertising cookies enables it and its partners to serve ads to you based on your visits to this Site and/or other sites on the Internet.")}</p>
            <p>
                {tr('You may opt out of personalised advertising by visiting {adsSettings}. You can also opt out of some third-party vendors’ use of cookies for personalised advertising at {aboutAds}. Learn more in {howGoogle}.', {
                    adsSettings: <External href="https://adssettings.google.com">{t('Google Ads Settings')}</External>,
                    aboutAds: <External href="https://www.aboutads.info/choices/">www.aboutads.info</External>,
                    howGoogle: <External href="https://policies.google.com/technologies/partner-sites">{t('how Google uses information from sites that use its services')}</External>,
                })}
            </p>
            <p>{t('Visitors in the European Economic Area, the UK and Switzerland are asked for consent through a Google-certified consent management platform before personalised ads are shown.')}</p>

            <h2>{t('5. Your rights')}</h2>
            <p>{t('Depending on where you live (for example under the GDPR or UK GDPR, or the CCPA in California), you may have the right to access, correct or delete personal data, and to object to or restrict certain processing. Because we do not store your tool data, there is usually no personal data for us to return. To make a request, contact us using the details below.')}</p>

            <h2>{t('6. Children')}</h2>
            <p>{t('The Site is not directed at children under 13, and we do not knowingly collect personal information from them.')}</p>

            <h2>{t('7. Changes to this policy')}</h2>
            <p>{t('We may update this policy from time to time. The “Last updated” date above shows when it last changed.')}</p>

            <h2>{t('8. Contact')}</h2>
            <p>{tr('Questions about privacy? Email {email}.', { email: <Email /> })}</p>
        </InfoPage>
    );
}

export function Terms() {
    const site = getSite();
    const name = site.name;
    return (
        <InfoPage page="terms" path="/terms">
            <h1>{t('Terms of Use')}</h1>
            <p className="muted">{t('Last updated: {date}', { date: formatDate(site.legalUpdated) })}</p>

            <p>{t('By using {name} (the “Site”) you agree to these terms. If you do not agree, please do not use the Site.', { name })}</p>

            <h2>{t('1. Use of the tools')}</h2>
            <p>{t('The tools are provided free of charge for personal and commercial use. You are responsible for the files and content you process and for making sure you have the right to use them.')}</p>

            <h2>{t('2. No warranty')}</h2>
            <p>{t('The Site and tools are provided “as is” and “as available”, without warranties of any kind. While we work hard to make every tool accurate, we do not guarantee that results will be error-free. Always keep a copy of your original files and double-check important results such as calculations.')}</p>

            <h2>{t('3. Limitation of liability')}</h2>
            <p>{t('To the fullest extent permitted by law, {name} is not liable for any loss or damage, including loss of data or profits, arising from your use of the Site or tools.', { name })}</p>

            <h2>{t('4. Acceptable use')}</h2>
            <p>{t('You agree not to misuse the Site, including attempting to disrupt it, overload it with automated requests, or use it for unlawful purposes.')}</p>

            <h2>{t('5. Advertising and third-party links')}</h2>
            <p>{t('The Site shows advertisements and may link to third-party websites. We are not responsible for the content or practices of those websites.')}</p>

            <h2>{t('6. Changes')}</h2>
            <p>{t('We may update these terms at any time. Continued use of the Site after changes means you accept the new terms.')}</p>

            <h2>{t('7. Contact')}</h2>
            <p>{tr('Questions? Email {email}.', { email: <Email /> })}</p>
        </InfoPage>
    );
}
