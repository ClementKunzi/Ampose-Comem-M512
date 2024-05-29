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
      boxShadow: {
        // 'tv': '0px 11px 3px rgba(0, 0, 0, 0), 0px 7px 3px, rgba(0, 0, 0, 0.01), 0px 4px 2px rgba(0, 0, 0, 0.05), 0px 2px 2px rgba(0, 0, 0, 0.09), 0px 0px 1px rgba(0, 0, 0, 0.1)',
        'tv': '0px 11px 3px rgba(0, 0, 0, 0), 0px 7px 3px rgba(0, 0, 0, 0.01), 0px 4px 2px rgba(0, 0, 0, 0.05), 0px 2px 2px rgba(0, 0, 0, 0.09), 0px 0px 1px rgba(0, 0, 0, 0.1)',
      
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


