const path = require('path')

const Encore = require('@symfony/webpack-encore')
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin

const isProduction = Encore.isProduction()

const assetsPath = path.resolve('./')
const outputPath = path.resolve('../dist')
const publicPath = '/wp-content/themes/wp-bootstrap-4/dist'

const vuePath = path.join(assetsPath, './vue')
const cssPath = path.join(assetsPath, './css')

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .cleanupOutputBeforeBuild()
    .setPublicPath(publicPath)
    .setOutputPath(outputPath)
    .disableSingleRuntimeChunk()
    .addEntry('_app',
        [
            path.join(vuePath, '/app.js'),
            path.join(cssPath, '/app.scss'),
        ],
    )
    .enableSassLoader()
    .enablePostCssLoader()
    .enableSourceMaps(!isProduction)
    .enableVersioning(isProduction)
    .enableVueLoader(() => {}, { runtimeCompilerBuild: false })
    .configureFilenames({
        js: './js/[name].min.js',
        css: './css/[name].min.css',
    })
    .addExternals({
        jquery: 'jQuery'
    })
    .addPlugin(
        new BundleAnalyzerPlugin({
            openAnalyzer: false,
        }),
    )
    .addAliases({
        '~': path.join(assetsPath, './node_modules'),
        '@': vuePath,
    })

const config = Encore.getWebpackConfig()

config.watchOptions = {
    poll: true,
    ignored: /node_modules/,
}

module.exports = config
