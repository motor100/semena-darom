import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/sass/main.scss',
                'resources/js/main.js',
                'resources/js/editor.js'
            ],
            refresh: true,
        }),
    ],
});
