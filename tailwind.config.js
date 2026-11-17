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
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Warna persis seperti UI Kit
                'neu-base': '#EBE9E1',       // Beige terang/warm
                'neu-primary': '#0F5C66',    // Dark Teal persis di tombol UI Kit
                'neu-primary-dark': '#0B474F',
                'neu-dark': '#3A3A3A',
                'neu-muted': '#9CA3AF',
            },
            boxShadow: {
                // Kalkulasi shadow solid (bukan rgba) agar halus seperti desain asli
                'neu-raised': '8px 8px 16px #d1cfc8, -8px -8px 16px #ffffff',
                'neu-hover': '10px 10px 20px #d1cfc8, -10px -10px 20px #ffffff',
                'neu-inset': 'inset 6px 6px 12px #d1cfc8, inset -6px -6px 12px #ffffff',
                'neu-pressed': 'inset 8px 8px 16px #c4c2ba, inset -8px -8px 16px #ffffff',
            }
        },
    },

    plugins: [forms],
};