/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './**/*.blade.php',
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/line-clamp'),
        require('tailwind-scrollbar'),
    ]
}