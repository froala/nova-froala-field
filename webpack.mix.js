let mix = require('laravel-mix');

let distPath = 'dist';

mix.setPublicPath(distPath)
   .js('resources/js/field.js', 'js')
   .sass('resources/sass/field.scss', 'css')
   .styles(
       'node_modules/froala-editor/css/froala_style.min.css',
       distPath + '/css/froala_styles.min.css'
   )
   .webpackConfig({
       output: {
           publicPath: '/',
           chunkFilename: 'vendor/nova/froala/[name].js',
       },
       resolve: {
           symlinks: false
       },
   });
