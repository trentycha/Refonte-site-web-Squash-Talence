import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['assets/js/app.js', 'assets/css/app.css'],
            refresh: true,
        }),
    ],
});
