const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .enableStimulusBridge('./assets/controllers.json')
    .splitEntryChunks()

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')
    .enableSingleRuntimeChunk()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })
    .enableSassLoader()
    .copyFiles({
        from: './assets/medias',
        to: 'medias/[path][name].[hash:8].[ext]'
    })
    .copyFiles({
        from: './assets/tokens',
        to: 'uploads/[path][name].[ext]'
    })
    .copyFiles({
        from: './assets/dice-themes',
        to: '../assets/themes/[path][name].[ext]',
        includeSubdirectories: true
    })
;

module.exports = Encore.getWebpackConfig();
