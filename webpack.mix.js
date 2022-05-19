const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .postCss('resources/css/admin.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .sass('resources/css/app.scss', 'public/css', [])
    .sass('resources/css/admin.scss', 'public/css', [])
    .sass('resources/css/blog.scss', 'public/css', [])
    .sass('resources/css/admin-blog.scss', 'public/css', [])
    .js('resources/js/script.js','public/js')
    .js('resources/js/admin.js','public/js');
    
if (mix.inProduction()) {
    mix.version()
}

mix.webpackConfig({
    stats: {
        children: true
    }
});