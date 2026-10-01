// Page-level motion: page-change fade, scroll reveal, smooth in-page scrolling.
// Only opacity and transform are animated (no layout shift), nothing that is on screen
// at load is ever hidden (no delay to the first paint), and everything is off for
// visitors who ask their system for less motion, and for crawlers.
import { useEffect, useRef } from 'react';
import { prefersReducedMotion } from './motion.js';

const BOTS = /bot|crawl|spider|slurp|lighthouse|google-inspectiontool|bingpreview/i;
const SECTIONS = '#main section';
const CARDS = '.tool-card, .browse-card';

function motionAllowed() {
    return typeof window !== 'undefined' && !prefersReducedMotion() && !BOTS.test(navigator.userAgent) && 'IntersectionObserver' in window;
}

/** Hide sections that are still below the fold, and fade them up when they scroll into view. */
function setUpReveal() {
    const pending = [];
    for (const el of document.querySelectorAll(SECTIONS)) {
        if (el.closest('.reveal-pending') || el.getBoundingClientRect().top < window.innerHeight) continue;
        el.querySelectorAll(CARDS).forEach((card, i) => card.style.setProperty('--i', String(i % 12)));
        el.classList.add('reveal-pending');
        pending.push(el);
    }
    if (pending.length === 0) return () => {};

    const timers = [];
    const io = new IntersectionObserver(
        (entries) => {
            for (const entry of entries) {
                if (!entry.isIntersecting) continue;
                const el = entry.target;
                io.unobserve(el);
                el.classList.add('reveal-in');
                el.classList.remove('reveal-pending');
                // Drop the staggered transitions afterwards so hover effects stay instant.
                timers.push(setTimeout(() => el.classList.remove('reveal-in'), 1400));
            }
        },
        { rootMargin: '0px 0px -8% 0px' },
    );
    pending.forEach((el) => io.observe(el));

    return () => {
        io.disconnect();
        timers.forEach(clearTimeout);
        pending.forEach((el) => el.classList.remove('reveal-pending', 'reveal-in'));
    };
}

/** Run on every route change from the Layout. */
export function usePageMotion(pathname, mainRef) {
    const first = useRef(true);

    useEffect(() => {
        if (!motionAllowed()) return undefined;
        const main = mainRef.current;
        // Page change: fade the new page in (never on the first load).
        if (!first.current && main) {
            main.classList.remove('page-enter');
            void main.offsetWidth; // restart the animation
            main.classList.add('page-enter');
        }
        first.current = false;

        let cleanup = () => {};
        const frame = requestAnimationFrame(() => {
            cleanup = setUpReveal();
        });
        return () => {
            cancelAnimationFrame(frame);
            cleanup();
        };
    }, [pathname, mainRef]);

    // Smooth scrolling for in-page links (#popular...). The skip link keeps its default jump.
    useEffect(() => {
        const onClick = (e) => {
            const link = e.target instanceof Element ? e.target.closest('a[href^="#"]') : null;
            if (!link || link.classList.contains('skip-link') || e.defaultPrevented || e.button !== 0) return;
            const target = document.getElementById(decodeURIComponent(link.getAttribute('href').slice(1)));
            if (!target) return;
            e.preventDefault();
            target.scrollIntoView({ behavior: prefersReducedMotion() ? 'auto' : 'smooth', block: 'start' });
            history.replaceState(history.state, '', link.getAttribute('href'));
        };
        document.addEventListener('click', onClick);
        return () => document.removeEventListener('click', onClick);
    }, []);
}
