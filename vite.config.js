import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';

const isDev = process.env.NODE_ENV === 'development';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true, // Ignored in prod
        }),
    ],
    // build: {
    //     outDir: 'public/build',
    //     manifest: true,
    // },
    server: isDev ? {
        host: 'ungarische-kolonie-berlin.test',
        port: 5173,
        https: {
            key: fs.readFileSync('/Users/daniel.kortvelyessy/Library/Application Support/Herd/config/valet/Certificates/ungarische-kolonie-berlin.test.key'),
            cert: fs.readFileSync('/Users/daniel.kortvelyessy/Library/Application Support/Herd/config/valet/Certificates/ungarische-kolonie-berlin.test.crt'),
        },
        hmr: {
            host: 'ungarische-kolonie-berlin.test',
            protocol: 'wss',
        },
    } : undefined,
});
