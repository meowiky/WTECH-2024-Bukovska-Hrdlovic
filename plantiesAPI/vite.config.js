import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/component.css',
                'resources/css/forms.css',
                'resources/css/generic.css',
                'resources/css/navigation.css',
                'resources/css/products.css',
                'resources/css/profile.css',
                'resources/css/register.css',
                'resources/css/shop-detail.css',
            ],
            refresh: true,
        }),
    ],
});
