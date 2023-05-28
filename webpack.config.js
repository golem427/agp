const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/app.js')

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push('@babel/a-babel-plugin');
    // })

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();

const CopyPlugin = require('copy-webpack-plugin');
const HandlebarsPlugin = require('handlebars-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
const TerserPlugin = require('terser-webpack-plugin');
const autoprefixer = require('autoprefixer');
const path = require('path');
const package = require('./package.json');

const paths = {
  src: {
    favicon: './src/favicon',
    fonts: './src/fonts',
    img: './src/img',
    js: './src/js',
    scss: './src/scss',
    video: './src/video',
  },
  dist: {
    css: './assets/css',
    favicon: './assets/favicon',
    fonts: './assets/fonts',
    img: './assets/img',
    js: './assets/js',
    video: './assets/video',
  },
};

module.exports = {
  devtool: 'source-map',
  entry: {
    libs: [paths.src.scss + '/libs.scss'],
    theme: [paths.src.js + '/theme.js', paths.src.scss + '/theme.scss'],
  },
  mode: 'development',
  module: {
    rules: [
      {
        test: /\.(sass|scss)$/,
        include: path.resolve(__dirname, paths.src.scss.slice(2)),
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
          },
          {
            loader: 'css-loader',
            options: {
              url: false,
            },
          },
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [['autoprefixer']],
              },
            },
          },
          {
            loader: 'sass-loader',
          },
        ],
      },
    ],
  },
  optimization: {
    splitChunks: {
      cacheGroups: {
        vendor: {
          test: /[\\/](node_modules)[\\/].+\.js$/,
          name: 'vendor',
          chunks: 'all',
        },
      },
    },
    minimizer: [
      new CssMinimizerPlugin(),
      new TerserPlugin({
        extractComments: false,
        terserOptions: {
          output: {
            comments: false,
          },
        },
      }),
    ],
  },
  output: {
    filename: paths.dist.js + '/[name].bundle.js',
  },
  plugins: [
    new CopyPlugin({
      patterns: [
        {
          from: paths.src.favicon,
          to: paths.dist.favicon,
        },
        {
          from: paths.src.fonts,
          to: paths.dist.fonts,
        },
        {
          from: paths.src.img,
          to: paths.dist.img,
        },
        {
          from: paths.src.video,
          to: paths.dist.video,
        },
      ],
    }),
    new HandlebarsPlugin({
      entry: path.join(process.cwd(), 'src', 'html', '**', '*.html'),
      output: path.join(process.cwd(), 'dist', '[path]', '[name].html'),
      partials: [path.join(process.cwd(), 'src', 'partials', '**', '*.{html,svg}')],
      helpers: {
        is: function (v1, v2, options) {
          const variants = v2.split(' || ');
          const isTrue = variants.some((variant) => v1 === variant);

          return isTrue ? options.fn(this) : options.inverse(this);
        },
        isnt: function (v1, v2, options) {
          return v1 !== v2 ? options.fn(this) : options.inverse(this);
        },
        webRoot: function () {
          return '{{webRoot}}';
        },
        themeVersion: function () {
          return '{{themeVersion}}';
        },
      },
      onBeforeSave: function (Handlebars, resultHtml, filename) {
        const level = filename.split('//').pop().split('/').length;
        const resultHtmlWithWebRoot = resultHtml.replaceAll('{{webRoot}}', '.'.repeat(level));
        const resultHtmlWithThemeVersion = resultHtmlWithWebRoot.replaceAll('{{themeVersion}}', package.version);

        return resultHtmlWithThemeVersion;
      },
    }),
    new RemoveEmptyScriptsPlugin(),
    new MiniCssExtractPlugin({
      filename: paths.dist.css + '/[name].bundle.css',
    }),
  ],
  devServer: {
    watchFiles: ['src/html/**/*', 'src/partials/**/*'],
  },
  target: 'web',
};
