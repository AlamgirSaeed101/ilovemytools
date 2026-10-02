import { createElement, lazy } from 'react';

// One converter component, several landing pages: each page fixes the output format.
const converter = (to) =>
    lazy(() => import('./ImageConverter.jsx').then((m) => ({ default: (props) => createElement(m.default, { ...props, to }) })));

// Slug (must match the key in config/tools.php) => React component.
// Each tool is lazy-loaded into its own small JavaScript file.
const tools = {
    'word-counter': lazy(() => import('./WordCounter.jsx')),
    'case-converter': lazy(() => import('./CaseConverter.jsx')),
    'password-generator': lazy(() => import('./PasswordGenerator.jsx')),
    'qr-code-generator': lazy(() => import('./QrCodeGenerator.jsx')),
    'image-compressor': lazy(() => import('./ImageCompressor.jsx')),
    'image-resizer': lazy(() => import('./ImageResizer.jsx')),
    'jpg-to-pdf': lazy(() => import('./JpgToPdf.jsx')),
    'webp-to-png': converter('image/png'),
    'png-to-jpg': converter('image/jpeg'),
    'jpg-to-png': converter('image/png'),
    'avif-to-jpg': converter('image/jpeg'),
    'avif-to-png': converter('image/png'),
    'avif-to-webp': converter('image/webp'),
    'readability-checker': lazy(() => import('./ReadabilityChecker.jsx')),
    'ai-content-detector': lazy(() => import('./AiDetector.jsx')),
    'remove-background': lazy(() => import('./BackgroundRemover.jsx')),
    'broken-link-checker': lazy(() => import('./BrokenLinkChecker.jsx')),
    'domain-authority-checker': lazy(() => import('./DomainAuthority.jsx')),
    'merge-pdf': lazy(() => import('./MergePdf.jsx')),
    'split-pdf': lazy(() => import('./SplitPdf.jsx')),
    'age-calculator': lazy(() => import('./AgeCalculator.jsx')),
    'percentage-calculator': lazy(() => import('./PercentageCalculator.jsx')),
    'tip-calculator': lazy(() => import('./TipCalculator.jsx')),
    'json-formatter': lazy(() => import('./JsonFormatter.jsx')),
    'base64-encoder-decoder': lazy(() => import('./Base64Tool.jsx')),
    'what-is-my-ip': lazy(() => import('./WhatIsMyIp.jsx')),
    'dice-roller': lazy(() => import('./DiceRoller.jsx')),
    'coin-flip': lazy(() => import('./CoinFlip.jsx')),
    'spin-the-wheel': lazy(() => import('./SpinWheel.jsx')),
    'random-number-generator': lazy(() => import('./RandomNumber.jsx')),
    'stopwatch': lazy(() => import('./Stopwatch.jsx')),
    'countdown-timer': lazy(() => import('./CountdownTimer.jsx')),
    'sleep-calculator': lazy(() => import('./SleepCalculator.jsx')),
};

export default tools;
