import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/turnos.css',
                'resources/js/turnos.js',
                'resources/css/registro.css',
                'resources/css/index.css',
                'resources/css/admin.css',
                'resources/css/cliente.css',
                'resources/css/recepcionista.css',
            ],
            refresh: ['resources/views/**/*'],
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
});