import ExtractTextPlugin from 'extract-text-webpack-plugin';
import path from 'path';
import webpack from 'webpack';

import packageJson from './package.json';

const main = () => {
  const PROD = process.argv.includes('-p');
  const min = PROD ? '.min' : '';
  const entry = {
    [packageJson.name]: ['./src/js/index.js', './src/sass/main.scss'],
  };
  const filename = `${packageJson.name}${min}.js`;
  const plugins = [new ExtractTextPlugin(`${packageJson.name}${min}.css`)];

  return {
    entry,
    output: {
      filename,
      path: path.resolve(__dirname, 'dist'),
    },
    plugins,
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /node_modules/,
          use: [
            {
              loader: 'babel-loader',
              options: {
                presets: ['react', 'env', 'stage-0'],
                plugins: ['transform-runtime'],
              },
            },
          ],
        },
        {
          test: /\.scss$|.css$/,
          use: ExtractTextPlugin.extract({
            fallback: 'style-loader',
            use: [
              { loader: 'css-loader', options: { sourceMap: true } },
              { loader: 'postcss-loader', options: { sourceMap: true } },
              { loader: 'sass-loader', options: { sourceMap: true } },
            ],
          }),
        },
        {
          test: /\.(png|svg|jpg|gif)$/,
          use: { loader: 'file-loader', options: { publicPath: '' } },
        },
        {
          test: /\.(woff|woff2|eot|ttf|otf)$/,
          use: { loader: 'file-loader', options: { publicPath: '' } },
        },
      ],
    },
    devtool: PROD ? false : 'source-maps',
  };
};

export default main;
