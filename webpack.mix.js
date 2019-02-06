let mix = require('laravel-mix');

mix.js('resources/js/pages/index/index.js', 'public/js')
	.autoload({
		jquery: [
			'$', 
			'window.jQuery', 
			'jQuery'
		]
	});

mix.sass('resources/sass/critical.scss', 'public/css/critical.css')
	.sass('resources/sass/pages/index.scss', 'public/css/index.css');