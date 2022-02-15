// webpack.mix.js

let mix = require('laravel-mix');

mix
    .js('templates/Froxlor/src/main.js', 'templates/Froxlor/assets/js')
    .sass('templates/Froxlor/src/scss/main.scss', 'templates/Froxlor/assets/css');