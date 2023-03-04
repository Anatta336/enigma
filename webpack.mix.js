let mix = require('laravel-mix');

mix
    .copyDirectory('resources/fonts', 'public/fonts')
    .js('resources/js/app.js', 'js').vue({
        version: 3,
    })
