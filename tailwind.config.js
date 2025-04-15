import tailwindcss from "tailwindcss";

module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/views/event_template/*.blade.php', // Main template
        './resources/views/components/**/*.blade.php',  // Flux components
    ],
    theme: {
        extend: {
            backgroundImage: {
                'parchment': "url('/build/assets/parchment-DBxaA9Y_.svg)", // Adjust to your image path
            },
        },
    },
    plugins: [],
};
