/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  
  plugins: [require("daisyui")],
  daisyui: {
    themes: ["light", "dark", "cupcake", 'wireframe'],
  },
}