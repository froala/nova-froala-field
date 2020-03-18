<?php

namespace Froala\NovaFroalaField;

use Froala\NovaFroalaField\Http\Controllers\FroalaToTrixAttachmentAdapterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Controllers\TrixAttachmentController;
use Laravel\Nova\Nova;

class FroalaFieldServiceProvider extends ServiceProvider
{
    public const ASSETS_DIST_DIRECTORY = __DIR__.'/../dist';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(FroalaPlugins $froalaPlugins)
    {
        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) use ($froalaPlugins) {
            Nova::script('nova-froala-field', static::ASSETS_DIST_DIRECTORY.'/js/field.js');
            Nova::style('nova-froala-field', static::ASSETS_DIST_DIRECTORY.'/css/field.css');

            $froalaPlugins->import();
        });

        $this->registerPublishables();
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

        $this->app->bind(FroalaPlugins::class, FroalaPluginsManager::class);

        if (config('nova.froala-field.attachments_driver') === 'trix') {
            $this->app->bind(TrixAttachmentController::class, FroalaToTrixAttachmentAdapterController::class);
        }
    }

    private function registerPublishables(): void
    {
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
}
