// webpack.mix.js

let mix = require('laravel-mix');

mix
	.setPublicPath('templates/Froxlor/assets')
	.options({
		processCssUrls: false
	})
	.copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'templates/Froxlor/assets/webfonts')
	.js('templates/Froxlor/src/js/main.js', 'js')
	.sass('templates/Froxlor/src/scss/main.scss', 'css')
	.sass('templates/Froxlor/src/scss/dark.scss', 'css')
	.version();
