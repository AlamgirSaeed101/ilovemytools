import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
        tailwindcss(),
    ],
    build: {
        // Each tool is code-split into its own chunk, so a page only downloads
        // the JavaScript for the tool it shows (good for Core Web Vitals / SEO).
        chunkSizeWarningLimit: 700,
    },
    test: {
        include: ['resources/js/**/*.test.js'],
        environment: 'node',
    },
});
