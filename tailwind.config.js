const colors = require('tailwindcss/colors')

module.exports = {
    content: require('fast-glob').sync([
        'source/**/*.blade.php',
        'source/**/*.md',
        'source/**/*.html',
    ]),
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
                gray: colors.zinc,
            }
        },
    },
    plugins: [
        require('@tailwindcss/typography'),
    ],
}
