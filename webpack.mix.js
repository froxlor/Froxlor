// webpack.mix.js

let mix = require('laravel-mix');

mix
    .js('templates/Froxlor/src/js/main.js', 'templates/Froxlor/assets/js')
    .sass('templates/Froxlor/src/scss/main.scss', 'templates/Froxlor/assets/css')
    .sass('templates/Froxlor/src/scss/dark.scss', 'templates/Froxlor/assets/css');