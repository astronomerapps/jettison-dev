const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const TsconfigPathsPlugin = require('tsconfig-paths-webpack-plugin');
const path = require('path');
const webpack = require('webpack');
const IgnoreEmitPlugin = require("ignore-emit-webpack-plugin");

const isDev = process.env.NODE_ENV === 'development'

const prodPlugins = [];
const devPlugins = [];
const cssPlugins = [];
const BASE_URL = path.resolve(__dirname, 'assets');

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
      'jettison.php',
      'includes/*.php',
      'languages/*.php',
      'views/*.php',
      'assets/fonts/**/*',
      'assets/images/**/*',
      'assets/js/**/*',
      'assets/css/**/*',
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
    'jettison-admin-scripts': path.resolve(BASE_URL, 'js/admin.ts'),
    'jettison-admin-styles': path.resolve(BASE_URL, 'css/admin.css'),
    'jettison-public-scripts': path.resolve(BASE_URL, 'js/public.ts'),
    'jettison-public-styles': path.resolve(BASE_URL, 'css/public.css'),
  },
  devtool: isDev ? 'inline-source-map' : false,
  target: 'web',
  mode: process.env.NODE_ENV,
  stats: {
    // warnings: false,
  }, // Hide warnings
  watchOptions: {
    poll: 100
  },
  output: {
    path: path.resolve(BASE_URL, 'dist'),
    filename: '[name].js',
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        include: [path.resolve(BASE_URL, 'js')],
        loader: 'vue-loader',
        options: {},
      },
      {
        test: /\.js$/,
        include: [path.resolve(BASE_URL, 'js')],
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
          },
        },
      },
      {
        test: /\.ts(x?)$/,
        include: [path.resolve(BASE_URL, 'js')],
        loader: {
          loader: 'ts-loader',
          options: {
            // configFile: path.resolve(BASE_URL, 'tsconfig.json')
          }
        }
      },
      {
        test: /\.css$/,
        include: [path.resolve(BASE_URL, 'css')],
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
        include: [path.resolve(BASE_URL, 'fonts')],
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
    new IgnoreEmitPlugin(['jettison-admin-css.js', 'jettison-public-css.js']),
    ...devPlugins,
    ...prodPlugins,
    new webpack.ProvidePlugin({
      // throttle: 'lodash.throttle',
    }),
    new VueLoaderPlugin(),
  ],
  resolve: {
    extensions: ['.js', '.css', '.vue', '.tsx', '.ts'],
    plugins: [
      new TsconfigPathsPlugin({
        // configFile: path.resolve(BASE_URL, 'tsconfig.json')
      }),
    ]
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
