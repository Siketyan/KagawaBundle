const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('./src/Resources/public/')
    .setPublicPath('/')
    .setManifestKeyPrefix('bundles/kagawa')

    .cleanupOutputBeforeBuild()
    .enableSassLoader()
    .enableSourceMaps(false)
    .enableVersioning(false)
    .disableSingleRuntimeChunk()

    .copyFiles({
        from: './assets/',
        to: 'images/[path][name].[ext]',
        pattern: /\.svg$/
    })

    .addEntry('bundle', './assets/bundle.js')
;

module.exports = Encore.getWebpackConfig();
