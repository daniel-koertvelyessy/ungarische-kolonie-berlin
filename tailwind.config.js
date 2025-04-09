import tailwindcss from "tailwindcss";

module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            backgroundImage: {
                // Use a relative path from resources, Vite will process it
                'parchment-stretch': "url('../images/parchment.svg')",
            },
        },
    },
    plugins: [],
};
