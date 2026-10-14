import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#3C50E0',
                    hover: '#3042C9',
                    light: '#EFEFEE',
                },
                boxdark: {
                    DEFAULT: '#24303F',
                    2: '#1A222C',
                    3: '#313D4A',
                },
                strokedark: '#2E3A47',
                bodydark: '#8A99AD',
                bodydark1: '#DEE4EE',
                bodydark2: '#8E99A8',
            },
        },
    },

    plugins: [forms],
};
