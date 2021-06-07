const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();

mix.styles([
    "node_modules/codemirror/lib/codemirror.css"
],"public/css/codemirror.css");

mix.scripts([
    "node_modules/codemirror/lib/codemirror.js"
],"public/js/codemirror.js");

mix.styles([
    "node_modules/codemirror/theme/erlang-dark.css"
],"public/css/themes.css");

mix.scripts([
    "node_modules/codemirror/mode/javascript/javascript.js",
    "node_modules/codemirror/mode/clike/clike.js"
],"public/js/modes.js");