let mix = require('laravel-mix');

mix.postCss("src/app.css", "css", [
    require("tailwindcss"),
])
.copy('src/fonts', 'dist/fonts')
.disableSuccessNotifications()
.setPublicPath('dist')
.sourceMaps()
.version();
