const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const path = require('path');
const webpack = require('webpack');
const IgnoreEmitPlugin = require("ignore-emit-webpack-plugin");

const isDev = process.env.NODE_ENV === 'development'

const prodPlugins = [];
const devPlugins = [];
const cssPlugins = [];

cssPlugins.push(require('postcss-easy-import')());
cssPlugins.push(require('postcss-assets')({
  cachebuster: true,
  cache: true,
}));
cssPlugins.push(require('postcss-preset-env')({
  browsers: 'last 2 versions',
  stage: 1,
}));
cssPlugins.push(require('postcss-nested')());

if (!isDev) {
  cssPlugins.push(require('cssnano')());
} else {
  devPlugins.push(new BrowserSyncPlugin({
    files: [
      'assets/*.php',
      'assets/fonts/**/*',
      'assets/images/**/*',
      'assets/js/**/*',
      'assets/css/**/*',
      'includes/**/*.php',
      'views/**/*.php',
      'languages/*.pot',
      'jettison.php',
    ],
    reloadDelay: 0,
    notify: {
      styles: {
        top: 'auto',
        bottom: '0',
        right: 'auto',
        left: '0',
        borderBottomLeftRadius: '0',
        borderBottomRightRadius: '0',
        border: 'none',
        fontSize: '0.8em',
        backgroundColor: 'rgba(136,224,111,0.75)',
        width: '100%',
      },
    },
  }));
}

module.exports = {
  entry: {
    'jettison-admin-scripts': path.resolve(__dirname, 'assets/js/admin.js'),
    'jettison-admin-styles': path.resolve(__dirname, 'assets/css/admin.css'),
    'jettison-public-scripts': path.resolve(__dirname, 'assets/js/public.js'),
    'jettison-public-styles': path.resolve(__dirname, 'assets/css/public.css'),
  },
  devtool: isDev ? 'inline-source-map' : false,
  target: 'web',
  mode: process.env.NODE_ENV,
  stats: {
    warnings: false,
  }, // Hide warnings
  output: {
    path: path.resolve(__dirname, 'assets/dist'),
    filename: '[name].js',
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        include: [path.resolve(__dirname, 'assets/js')],
        loader: 'vue-loader',
        options: {},
      },
      {
        test: /\.js$/,
        include: [path.resolve(__dirname, 'assets/js')],
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
          },
        },
      },
      {
        test: /\.css$/,
        include: [path.resolve(__dirname, 'assets/css')],
        use: [
          {
            loader: MiniCssExtractPlugin.loader
          },
          {
            loader: 'css-loader',
            options: { importLoaders: 1 },
          },
          {
            loader: 'postcss-loader',
            options: {
              ident: 'postcss',
              sourceMap: process.env.NODE_ENV !== 'production' ? 'inline' : false,
              plugins: cssPlugins,
            },
          },
        ],
      },
      {
        test: /\.woff|ttf|eot|svg$/,
        include: [path.resolve(__dirname, 'assets/fonts')],
        use: [
          {
            loader: 'file-loader',
            options: {
              name() {
                if (process.env.NODE_ENV === 'development') {
                  return '[name].[ext]';
                }
                return '[hash].[ext]';
              },
              outputPath: 'fonts',
              // publicPath: '/wp-content/themes/athlete/public/fonts',
            },
          },
        ],
      },
      {
        test: /\.(png|svg|jpg|gif)$/,
        use: ['file-loader'],
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '[name].css',
      chunkFilename: '[id].css',
    }),
    /**
     * Ignore the empty js files that get generated
     * Will be fixed in webpack@5
     */
    new IgnoreEmitPlugin(['admincss.js', 'publiccss.js']),
    ...devPlugins,
    ...prodPlugins,
    new webpack.ProvidePlugin({
      // throttle: 'lodash.throttle',
    }),
    new VueLoaderPlugin(),
  ],
  resolve: {
    extensions: ['.js', '.css', '.vue'],
  },
  optimization: {
    chunkIds: isDev ? 'named' : 'total-size',
    minimizer: isDev ? [] : [
      new UglifyJsPlugin({
        cache: true,
        parallel: true,
        uglifyOptions: {
          warnings: false,
          parse: {},
          compress: {},
          mangle: true,
          output: null,
          ie8: false,
          keep_fnames: false,
          toplevel: false,
        }
      })
    ],
  }
};
