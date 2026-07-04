import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/css/admin-login.css', 'resources/js/app.js', 'resources/js/admin-login.js', 'resources/js/pkl-absensi.js', 'resources/js/scan-machine.js'],
            refresh: true,
            fonts: [
                bunny('Inter', {
                    weights: ['400', '500', '600', '700', '800'],
                }),
                bunny('JetBrains Mono', {
                    weights: ['400', '500', '600'],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        hmr: {
            host: '192.168.1.8',
            protocol: 'http',
            port: 5173,
        },
        cors: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
