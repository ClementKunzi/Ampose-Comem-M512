/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  options: {
    safelist: ['.router-link-active'],
  },
  theme: {
    extend: {
      colors: {
        'tv-wine': '#754043',
        'tv-beige': '#FAF0CA',
        'tv-eggshell': '#F5f5f5',
      },
    },
    fontFamily: {
      'sans': ['bilo', 'roboto', 'ui-sans-serif', 'system-ui'],
      'serif': ['"Made Mountain"', 'ui-serif', 'Georgia', ],      
    }
  },
  purge: {    
    options: {
      safelist: ['.router-link-active'],
    },
  },
  plugins: [],
}


