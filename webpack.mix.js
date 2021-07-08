const mix = require('laravel-mix');
require('laravel-mix-jigsaw');

mix.disableSuccessNotifications();
mix.setPublicPath('source/assets/build');

mix.jigsaw()
    .copy('source/_assets/fonts', 'source/assets/build/fonts')
    .css("source/_assets/css/font.css", "css")
    .postCss("source/_assets/css/app.css", "css", [
        require("tailwindcss"),
    ])
    .options({
        processCssUrls: false,
    })
    .sourceMaps()
    .version();
