import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/auth/login.css', 'resources/css/auth/register.css', 'resources/js/auth/login.js', 'resources/js/auth/register.js', 'resources/css/layouts/warga.css', 'resources/js/layouts/warga.js', 'resources/css/layouts/admin.css', 'resources/js/layouts/admin.js', 'resources/css/welcome.css', 'resources/js/welcome.js', 'resources/css/partials/navbar.css', 'resources/css/partials/footer.css', 'resources/css/partials/sidebar.css', 'resources/js/partials/navbar.js', 'resources/js/partials/sidebar.js', 'resources/css/warga/dashboard.css', 'resources/js/warga/dashboard.js', 'resources/css/admin/dashboard.css', 'resources/js/admin/dashboard.js'],
            refresh: true,
        }),
    ],
});
