const { VueLoaderPlugin } = require('vue-loader')


var Encore = require('@symfony/webpack-encore'); Encore
    .setOutputPath('web/jsbuild/')
    .setPublicPath('/jsbuild')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .addEntry('js/app', './vuejs/assets/js/app.js')
    .addEntry('js/appDashboard', './vuejs/assets/js/dashboard-app/app.js')

    // .addStyleEntry('css/app', './assets/css/app.scss')
    // .enableSassLoader()
    .autoProvidejQuery()


    // Enable Vue loader
    .enableVueLoader()

    .addPlugin(new VueLoaderPlugin())

    .configureBabel(config => {
        config.presets = ['es2015','stage-0'];
        config.plugins = [
            require('babel-plugin-syntax-dynamic-import')
        ];
    });
;

module.exports = Encore.getWebpackConfig();