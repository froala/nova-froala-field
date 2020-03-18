<?php

namespace Froala\NovaFroalaField;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Str;
use Laravel\Nova\Nova;

class FroalaPluginsManager implements FroalaPlugins
{
    private $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    private function importTuiImageManager(): self
    {
        if ($this->config->get('nova.froala-field.options.tuiEnable')) {
            Nova::style(
                'tui-editor',
                FroalaFieldServiceProvider::ASSETS_DIST_DIRECTORY.'/css/plugins/tui-image-editor/tui-image-editor.min.css'
            );
            Nova::style(
                'tui-color-picker',
                FroalaFieldServiceProvider::ASSETS_DIST_DIRECTORY.'/css/plugins/tui-image-editor/tui-color-picker.min.css'
            );

            Nova::script(
                'fabric',
                FroalaFieldServiceProvider::ASSETS_DIST_DIRECTORY.'/js/plugins/tui-image-editor/fabric.js'
            );
            Nova::script(
                'tui-codesnippet',
                FroalaFieldServiceProvider::ASSETS_DIST_DIRECTORY.'/js/plugins/tui-image-editor/tui-code-snippet.min.js'
            );
            Nova::script(
                'tui-image-editor',
                FroalaFieldServiceProvider::ASSETS_DIST_DIRECTORY.'/js/plugins/tui-image-editor/tui-image-editor.min.js'
            );
        }

        return $this;
    }

    private function importFontAwesome(): self
    {
        if (Str::startsWith(
            $this->config->get('nova.froala-field.options.iconsTemplate'),
            'font_awesome_5'
        )) {
            Nova::script('font-awesome', 'https://use.fontawesome.com/releases/v5.0.8/js/all.js');
        }

        return $this;
    }

    public function import()
    {
        $this->importTuiImageManager()
            ->importFontAwesome();
    }
}
