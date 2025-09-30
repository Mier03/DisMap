import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // Input: Paths are relative to the 'web' folder (where npm run build is run)
            input: [
                'resources/css/app.css', // Should be relative to 'web'
                'resources/js/app.js',  // Should be relative to 'web'
            ],

            // ⚠️ CRITICAL PATH FIX ⚠️
            // This path must be RELATIVE TO THE CURRENT WORKING DIRECTORY ('web').
            // It points to the 'public' folder inside the 'backend' folder.
            publicDirectory: '../backend/public', 
            
            // Build Directory: The subfolder for the manifest/build assets, relative to publicDirectory.
            buildDirectory: 'build', 
            
            refresh: true,
        }),
    ],
});