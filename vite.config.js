import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        cors: true, // Aktiviert die CORS-Header
        host: '0.0.0.0', // Sicherstellen, dass der Server korrekt zugreifbar ist
    },
});
