let mix = require('laravel-mix');

mix.postCss("src/app.css", "css", [
    require("tailwindcss"),
])
.browserSync('http://leuver.ink.test')
.disableSuccessNotifications()
.setPublicPath('dist')
.sourceMaps()
.version();
