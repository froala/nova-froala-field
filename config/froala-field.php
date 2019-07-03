<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Editor Options
    |--------------------------------------------------------------------------
    |
    | Setup default values for any Froala editor option.
    |
    | To view a list of all available options checkout the Froala documentation
    | {@link https://www.froala.com/wysiwyg-editor/docs/options}
    |
    */

    'options' => [
        //'key' => env('FROALA_KEY'),
        //'iconsTemplate' => 'font_awesome_5',
        //'tuiEnable' => true,

        'toolbarButtons' => [
            [
                'bold',
                'italic',
                'underline',
            ],
            [
                'formatOL',
                'formatUL',
            ],
            [
                'insertImage',
                'insertFile',
                'insertLink',
                'insertVideo',
            ],
            [
                'html',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Editor Attachments Driver
    |--------------------------------------------------------------------------
    |
    | If you have used `Trix` previously and want to save the same flow with
    | `Trix` attachments handlers and database tables you can use
    | "trix" driver.
    |
    | *** Note that "trix" driver doesn't support image optimization
    | and file names preservation.
    |
    | It is recommended to use "froala" driver to be able to automatically
    | optimize uploaded images and preserve attachments file names.
    |
    | Supported: "froala", "trix"
    |
    */

    'attachments_driver' => 'froala',

    /*
    |--------------------------------------------------------------------------
    | Preserve Attachments File Name
    |--------------------------------------------------------------------------
    |
    | Ability to preserve client original file name for uploaded
    | image, file or video.
    |
    */

    'preserve_file_names' => false,

    /*
    |--------------------------------------------------------------------------
    | Maximum Possible Size for Uploaded Files
    |--------------------------------------------------------------------------
    |
    | Customize max upload filesize for uploaded attachments.
    | By default it is set to "null", it means that default value is
    | retrieved from `upload_max_size` directive of php.ini file.
    |
    | Format is the same as for `uploaded_max_size` directive.
    | Check out FAQ page, to get more detail description.
    | {@link http://php.net/manual/en/faq.using.php#faq.using.shorthandbytes}
    |
    */

    'upload_max_filesize' => null,

    /*
    |--------------------------------------------------------------------------
    | Automatically Images Optimization
    |--------------------------------------------------------------------------
    |
    | Optimize all uploaded images by default.
    |
    | * Currently not supported for cloud filesystems
    |
    */

    'optimize_images' => true,

    /*
    |--------------------------------------------------------------------------
    | Image Optimizers Setup
    |--------------------------------------------------------------------------
    |
    | These are the optimizers that will be used by default.
    | You could setup custom parameters for each optimizer.
    |
    */

    'image_optimizers' => [
        Spatie\ImageOptimizer\Optimizers\Jpegoptim::class => [
            '-m85', // this will store the image with 85% quality. This setting seems to satisfy Google's Pagespeed compression rules
            '--strip-all', // this strips out all text information such as comments and EXIF data
            '--all-progressive', // this will make sure the resulting image is a progressive one
        ],
        Spatie\ImageOptimizer\Optimizers\Pngquant::class => [
            '--force', // required parameter for this package
        ],
        Spatie\ImageOptimizer\Optimizers\Optipng::class => [
            '-i0', // this will result in a non-interlaced, progressive scanned image
            '-o2', // this set the optimization level to two (multiple IDAT compression trials)
            '-quiet', // required parameter for this package
        ],
        Spatie\ImageOptimizer\Optimizers\Svgo::class => [
            '--disable=cleanupIDs', // disabling because it is known to cause troubles
        ],
        Spatie\ImageOptimizer\Optimizers\Gifsicle::class => [
            '-b', // required parameter for this package
            '-O3', // this produces the slowest but best results
        ],
    ],
];
