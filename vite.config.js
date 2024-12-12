import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';


export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/style.scss',
                'resources/js/app.js',
                'node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css',
                
            ],
            refresh: true,
        }),

    ],
    build: {
        outDir: 'public/build',
    },
});
