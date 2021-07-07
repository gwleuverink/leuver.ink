let mix = require('laravel-mix');

mix
.css("src/font.css", "css")
.postCss("src/app.css", "css", [
    require("tailwindcss"),
])
.copy('src/fonts', 'dist/fonts')
.disableSuccessNotifications()
.setPublicPath('dist')
.sourceMaps()
.version();
