import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
        poppins: ['Poppins', 'sans-serif'],
        sans: ['Poppins', 'sans-serif'],
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        'cp-dark-blue': '#312ECB',
        'cp-light-grey': '#A0A0A0',
      },
      keyframes: {
        glow: {
          '0%, 100%': {
            boxShadow: '0 0 10px rgba(34, 197, 94, 0.6)',
          },
          '50%': {
            boxShadow: '0 0 20px rgba(34, 197, 94, 0.9)',
          },
        },
        flicker: {
          '0%, 100%': { opacity: 1 },
          '50%': { opacity: 0.4 },
        },
        'fade-in-blur': {
          '0%': {
            opacity: 0,
            filter: 'blur(10px)',
            transform: 'translateY(20px)',
          },
          '100%': {
            opacity: 1,
            filter: 'blur(0)',
            transform: 'translateY(0)',
          },
        }
      },
      animation: {
        glow: 'glow 1.8s ease-in-out infinite',
        flicker: 'flicker 0.8s infinite',
        'fade-in-blur': 'fade-in-blur 0.8s ease-out forwards',
            },
        },
    },

    plugins: [
        forms,
        require('flowbite/plugin')
    ],
};
