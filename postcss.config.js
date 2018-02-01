const color = require('css-color-function');
const postcssImport = require('postcss-import');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const themes = require('postcss-custom-props-themes');

module.exports = {
  plugins: [
    postcssImport,
    themes({
      defaultTheme: 'light',
      themes: [
        {
          name: 'light',
          color: '#353535',
          'background-color': 'white',
          'background-hover-color': color.convert('color(white shade(10%))'),
          'link-color': '#ba0c2f',
          'link-hover-color': '#ba0c2f',
          'heading-color': '#ba0c2f',
          'heading-link-color': '#ba0c2f',
          'heading-link-hover-color': '#ba0c2f',
          'border-color': color.convert('color(white shade(10%))'),
        },
        {
          name: 'primary',
          color: 'white',
          'background-color': '#ba0c2f',
          'background-hover-color': color.convert('color(#ba0c2f shade(10%))'),
          'link-color': 'white',
          'link-hover-color': 'white',
          'heading-color': 'white',
          'heading-link-color': 'white',
          'heading-link-hover-color': 'white',
          'border-color': color.convert('color(#ba0c2f tint(10%))'),
        },
      ],
    }),
    autoprefixer,
    cssnano,
  ],
};
