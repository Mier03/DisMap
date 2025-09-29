import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'g-dark': '#296E5B', 
                'g-light': '#B3FAD8',
                'g-bg': '#DCFCE7',
                'r-dark': '#B91C1C',
                'r-light': '#FCA5A5',
            },
            fontFamily: {
                sans: ['inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
