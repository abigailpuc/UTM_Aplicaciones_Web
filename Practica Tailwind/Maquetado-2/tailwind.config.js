/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,css}"],
  theme: {
    extend: {
      colors: {
        danger: '#FFB6C1',
        info: {
          900: '#87CEFA',
          800: '#285e61',
        },
        fondo1: '#00FF2E',
        fondo2: '#FFFFFF'
      },
    },
    fontFamily: {
      rale: ['Raleway'],
    },
  },
  plugins: [],
}