/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,hs}"],
  theme: {
    extend: {
      fontFamily: {
        plusJakartaSans: ['Plus Jakarta Sans', 'sans-serif'],
        poppins: ['Poppins', 'sans-serif']
      }
    },
  },
  plugins: [],
}

