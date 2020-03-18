let mix = require('laravel-mix');

let distPath = 'dist';

mix.setPublicPath(distPath)
    .js('resources/js/field.js', 'js')
    .sass('resources/sass/field.scss', 'css')
    .copy(
        'node_modules/froala-editor/css/froala_style.min.css',
        distPath + '/css/froala_styles.min.css'
    )
    // Copy 3rd parties
    .copy(
        'node_modules/tui-image-editor/dist/tui-image-editor.min.js',
        distPath + '/js/plugins/tui-image-editor'
    )
    .copy(
        'node_modules/tui-code-snippet/dist/tui-code-snippet.min.js',
        distPath + '/js/plugins/tui-image-editor'
    )
    .copy(
        'node_modules/fabric/dist/fabric.js',
        distPath + '/js/plugins/tui-image-editor/fabric.js'
    )
    .copy(
        'node_modules/tui-image-editor/dist/tui-image-editor.min.css',
        distPath + '/css/plugins/tui-image-editor'
    )
    .copy(
        'node_modules/tui-color-picker/dist/tui-color-picker.min.css',
        distPath + '/css/plugins/tui-image-editor'
    )
    // -----------------
    .webpackConfig({
        output: {
            publicPath: '/',
            chunkFilename: 'vendor/nova/froala/[name].js',
        },
        resolve: {
            symlinks: false
        },
    });
