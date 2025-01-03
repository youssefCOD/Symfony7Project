/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        'luxury-gold': 'var(--color-elegant-cream)',
        // ... other custom colors
      },
     
      },
  },
  plugins: [],
}

