module.exports = {
  theme: {
      extend: {
          fontFamily: {
              mono: [
                  '"Overpass Mono"',
                  'Menlo',
                  'Monaco',
                  'Consolas',
                  '"Liberation Mono"',
                  '"Courier New"',
                  'monospace',
              ],
          },
          width: {
              'screen-1/2': '50vw',
          },
      },
  },
  variants: {
      display: ['responsive', 'hover', 'focus', 'group-hover'],
  },
  plugins: []
};
