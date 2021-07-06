const colors = require('tailwindcss/colors')

module.exports = {
    mode: 'jit',
    purge: [
        './public/**/*.{html,js}',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        fontFamily: {
            sans: [
                'Karla',
                'system-ui',
                '-apple-system',
                'Segoe UI',
                'Roboto',
                'Helvetica',
                'Arial',
                'sans-serif',
                'Apple Color Emoji',
                'Segoe UI Emoji'
            ],
        },
        extend: {
            colors: {
                cyan: colors.cyan,
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/typography'),
    ],
}
