module.exports = {
    purge: [
        './resources/views/welcome.blade.php',
        './resources/js/app.js',
    ],
    theme: {
        extend: {},
    },
    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
    },
    plugins: [
        require('@tailwindcss/ui'),
    ],
}
