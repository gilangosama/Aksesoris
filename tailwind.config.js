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
                'blush': {
                    50: '#fdf8f7',
                    100: '#fae9e5',
                    200: '#f5d4cb',
                    300: '#f0bfb0',
                    400: '#eba996',
                    500: '#e59481',
                    600: '#de7f6c',
                    700: '#d66a57',
                    800: '#ce5542',
                    900: '#c6402d',
                    50: '#fdf2f2',
                    100: '#fde8e8',
                    200: '#fbd5d5',
                    300: '#f8b4b4',
                    400: '#f98080',
                    500: '#f05252',
                },
                'rose-gold': '#d4a574',
                'charcoal': '#2a2825',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            spacing: {
                'safe': 'var(--safe-area-inset-left)',
            },
            boxShadow: {
                'soft': '0 4px 20px rgba(0, 0, 0, 0.08)',
                'softer': '0 2px 12px rgba(0, 0, 0, 0.06)',
            },
        },
    },

    plugins: [forms],
};
