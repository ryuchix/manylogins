const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'darkblue': '#0b2239',
                'bodybg': '#f4f5f8',
                'body': '#f8fafc',
                'link': '#4ad295'
            },
        },
        screens: {
            'xsm': '475px',
            ...defaultTheme.screens,
        },
    },
    plugins: [],
}
