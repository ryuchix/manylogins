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
                'primary': '#0b2239',
                'secondary': '#f4f5f8',
                'body': '#f8fafc',
            },
        },
        screens: {
            'xsm': '475px',
            ...defaultTheme.screens,
        },
    },
    plugins: [],
}
