const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .enableSassLoader()
    .enableSingleRuntimeChunk()
    .copyFiles({
        from: './assets/img',      
        to: 'images/[name].[hash:8].[ext]'
    })
;

module.exports = Encore.getWebpackConfig();
