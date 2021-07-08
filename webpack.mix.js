const mix = require('laravel-mix');
require('laravel-mix-jigsaw');

mix.disableSuccessNotifications();
mix.setPublicPath('source/assets/build');

mix.jigsaw()
    .css("source/_assets/css/font.css", "css")
    .postCss("source/_assets/css/app.css", "css", [
        require('postcss-import'),
        require("tailwindcss"),
    ])
    .options({
        processCssUrls: false,
    })
    .copy('source/_assets/fonts', 'source/assets/build/fonts')
    .sourceMaps()
    .version();
