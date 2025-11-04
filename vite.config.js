import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    base: '', // 👈 fuerza rutas relativas (evita 404 en Railway)
    build: {
        outDir: 'public/build', // 👈 asegura que el build se guarde en /public/build
        manifest: true,
        emptyOutDir: true,
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
