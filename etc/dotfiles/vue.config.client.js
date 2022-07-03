const { LimitChunkCountPlugin, SingleEntryPlugin } = require('webpack')
const webpack = require('webpack')

module.exports = {
  lintOnSave: false,
  outputDir: './dist/bunny',
  publicPath: '/dist/bunny',
  filenameHashing: false,
  parallel: true,
  productionSourceMap: false,
  pluginOptions: {
    basedir: './src'
  },

  css: {
    extract: false
  },

  configureWebpack: {
    devtool: '#source-map',

    devServer: {
      watchOptions: {
        ignored: /node_modules/
      }
    },

    plugins: [
      new webpack.optimize.LimitChunkCountPlugin({
        maxChunks: 1
      })
    ],

    output: {
      filename: 'app.js',
      sourceMapFilename: 'app.js.map'
    },

    optimization: {
      splitChunks: false
    }
  }
}
