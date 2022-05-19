const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {    
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'darkblue': '#0b2239',
                'bodybg': '#f4f5f8',
                'body': '#f8fafc',
                'link': '#4ad295'
            }
        },
        screens: {
            'xsm': '475px',
            ...defaultTheme.screens,
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/line-clamp'),],
    
};
