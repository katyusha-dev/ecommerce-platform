const { LimitChunkCountPlugin, SingleEntryPlugin } = require('webpack')
const webpack = require('webpack')

module.exports = {
  lintOnSave: false,
  productionSourceMap: true,
  outputDir: './dist/server',
  publicPath: undefined,
  filenameHashing: false,
  parallel: true,
  pluginOptions: {
    basedir: './src'
  },

  css: {
    extract: false
  },

  configureWebpack: {
    target: 'node',

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
