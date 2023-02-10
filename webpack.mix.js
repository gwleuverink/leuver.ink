const mix = require('laravel-mix');
require('laravel-mix-jigsaw');

mix.disableSuccessNotifications();
mix.setPublicPath('source/assets/build');

mix.jigsaw()
    .js('source/_assets/js/app.js', 'js')
    .copy('source/_assets/fonts', 'source/assets/build/fonts')
    .css('source/_assets/css/font.css', 'css')
    .postCss('source/_assets/css/app.css', 'css', [
        require('tailwindcss'),
    ])
    .options({
        processCssUrls: false,
    })
    .browserSync({
        server: 'build_local',
        files: ['build_*/**'],
        port: 3001
    })
    .sourceMaps()
    .version();
