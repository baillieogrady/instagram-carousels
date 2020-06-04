module.exports = {
  theme: {
    extend: {
      borderRadius: {
        'xl': '1.5rem'
      }
    },
    colors: {
      blue: {
        '100': '#E7EEFC',
        '800': '#2B406C',
        '900': '#293C63'
      },
      green: {
        '400': '#5EAA7E'
      }
    },
    fill: theme => ({
      'blue': theme('colors.blue.100')
    }),
    gradients: theme => ({
      'blue-gradient': ['120deg', theme('colors.blue.900') + ' 0% 55.5%', theme('colors.blue.800') + ' 55.5% 100%'],
    }),
  },
  plugins: [
    require('tailwindcss-plugins/gradients'),
  ]
}
