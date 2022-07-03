const path = require('path')
const tsConfig = require('./tsconfig.json')
const _ = require('lodash')
const { defineConfig } = require('@vue/cli-service')
const { theme } = './src/tpl/config/theme/themeVariables'

const fs = require('fs')
const aliases = tsConfig.compilerOptions.paths

module.exports = defineConfig({
  // outputDir: 'public/dist',
  // filenameHashing: false,
  // parallel: 6,

  devServer: {
    allowedHosts: 'all',
    host: '0.0.0.0',
    proxy: 'https://katyusha.io',
    webSocketServer: {
      options: {
        url: 'ws://katyusha.io/ws'
      }
    }
  },

  publicPath:
      process.env.NODE_ENV === 'production'
        ? process.env.VUE_APP_SUB_ROUTE
          ? process.env.VUE_APP_SUB_ROUTE
          : process.env.BASE_URL
        : process.env.BASE_URL,
  css: {
    loaderOptions: {
      less: {
        lessOptions: {
          modifyVars: {
            ...theme
          },
          javascriptEnabled: true
        }
      }
    }
  },
  
  pwa: {
    name: 'Katyusha',
    themeColor: '#000000',
    msTileColor: '#000000',
    appleMobileWebAppCapable: 'yes',
    appleMobileWebAppStatusBarStyle: 'black',
    short_name: 'Shoply',
    start_url: './',
    display: 'standalone',
    workboxPluginMode: 'InjectManifest',
    workboxOptions: {
      swSrc: 'src/service-worker.js'
    },

    iconPaths: {
      faviconSVG: 'img/icons/favicon.svg',
      favicon32: 'img/icons/favicon-32x32.png',
      favicon16: 'img/icons/favicon-16x16.png',
      appleTouchIcon: 'img/icons/apple-touch-icon-152x152.png',
      maskIcon: 'img/icons/safari-pinned-tab.svg',
      msTileImage: 'img/icons/msapplication-icon-144x144.png'
    }

  },

  chainWebpack: config => {
    config.resolve.alias.set('@tpl', path.resolve(__dirname, 'src/tpl'))
    config.resolve.alias.set('@app', path.resolve(__dirname, 'src/app'))
    config.resolve.alias.set('@store', path.resolve(__dirname, 'src/store'))
    config.resolve.alias.set('@decorators', path.resolve(__dirname, 'src/decorators'))
    config.resolve.alias.set('@collections', path.resolve(__dirname, 'src/data/collections'))
    config.resolve.alias.set('@entities', path.resolve(__dirname, 'src/data/entities'))
    config.resolve.alias.set('@definitions', path.resolve(__dirname, 'src/definitions'))
    config.resolve.alias.set('@http', path.resolve(__dirname, 'src/http'))
    config.resolve.alias.set('@actions', path.resolve(__dirname, 'src/http/actions'))
    config.resolve.alias.set('@api', path.resolve(__dirname, 'src/http/api'))
    config.resolve.alias.set('@ioc', path.resolve(__dirname, 'src/ioc'))
    config.resolve.alias.set('@composables', path.resolve(__dirname, 'src/vue/composables'))
    config.resolve.alias.set('@components', path.resolve(__dirname, 'src/vue/components'))
    config.resolve.alias.set('@views', path.resolve(__dirname, 'src/vue/views'))

    // Object.keys(aliases).forEach((alias) => {
    //     const relativePath = aliases[alias][0]
    //     config.resolve.alias.set(_.replace(alias, '/*', ''), path.resolve(__dirname, _.replace(relativePath, '*', '')));
    // })
  },

  pluginOptions: {
    quasar: {
      importStrategy: 'kebab',
      rtlSupport: false
    }
  },

  transpileDependencies: [
    'quasar'
  ]
})
