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
    // server: {
    //     hmr: 'ungarische-kolonie-berlin.test', // set to whatever your host is
    //     origin: 'http://ungarische-kolonie-berlin.test',  // set to whatever your host is
    // },
});
