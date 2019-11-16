<?php

namespace Froala\NovaFroalaField;

use Froala\NovaFroalaField\Http\Controllers\FroalaToTrixAttachmentAdapterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Controllers\TrixAttachmentController;
use Laravel\Nova\Nova;

class FroalaFieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-froala-field', __DIR__.'/../dist/js/field.js');
            Nova::style('nova-froala-field', __DIR__.'/../dist/css/field.css');

            if ($this->app['config']->get('nova.froala-field.options.tuiEnable')) {
                Nova::style('tui-editor', 'https://cdn.jsdelivr.net/npm/tui-image-editor@3.2.2/dist/tui-image-editor.css');
                Nova::style('tui-color-picker', 'https://uicdn.toast.com/tui-color-picker/latest/tui-color-picker.css');

                Nova::script('fabric', 'https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.6.7/fabric.min.js');
                Nova::script('tui-codesnippet', 'https://cdn.jsdelivr.net/npm/tui-code-snippet@1.4.0/dist/tui-code-snippet.min.js');
                Nova::script('tui-image-editor', 'https://cdn.jsdelivr.net/npm/tui-image-editor@3.2.2/dist/tui-image-editor.min.js');
            }

            if (Str::startsWith(
                $this->app['config']->get('nova.froala-field.options.iconsTemplate'),
                'font_awesome_5'
            )) {
                Nova::script('font-awesome', 'https://use.fontawesome.com/releases/v5.0.8/js/all.js');
            }
        });

        $this->publishes([
            __DIR__.'/../dist/vendor/nova/froala' => public_path('vendor/nova/froala'),
        ], 'nova-froala-field-plugins');

        $this->publishes([
            __DIR__.'/../dist/css/froala_styles.min.css' => public_path('css/vendor/froala_styles.min.css'),
        ], 'froala-styles');

        $this->publishes([
            __DIR__.'/../config/froala-field.php' => config_path('nova/froala-field.php'),
        ], 'config');

        if (! class_exists('CreateFroalaAttachmentTables')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__.'/../database/migrations/create_froala_attachment_tables.php.stub' => database_path('migrations/'.$timestamp.'_create_froala_attachment_tables.php'),
            ], 'migrations');
        }
    }

    /**
     * Register the card's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
            ->prefix('nova-vendor/froala-field')
            ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/froala-field.php', 'nova.froala-field');

        if (config('nova.froala-field.attachments_driver') === 'trix') {
            $this->app->bind(TrixAttachmentController::class, FroalaToTrixAttachmentAdapterController::class);
        }
    }
}
