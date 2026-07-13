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
                'resources/js/registro.js',     // Busca este JS para el registro
                'resources/css/index.css',    // Cambiado definitivamente a index.css
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