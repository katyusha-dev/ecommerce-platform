const { LimitChunkCountPlugin, SingleEntryPlugin } = require('webpack')
const webpack = require('webpack')
const path = require('path')
const vueSrc = './src/'

module.exports = {
  lintOnSave: false,
  outputDir: './dist',
  publicPath: '/',
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

    resolve: {

      alias: {
        '@interfaces': path.resolve(__dirname, vueSrc + 'app/@interfaces'),
        '@enum': path.resolve(__dirname, vueSrc + 'app/@enum'),
        '@composables': path.resolve(__dirname, vueSrc + 'composables'),
        '@api': path.resolve(__dirname, vueSrc + 'app/api')
      }
    },

    devServer: {
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
