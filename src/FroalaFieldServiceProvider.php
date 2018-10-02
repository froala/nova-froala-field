<?php

namespace Froala\NovaFroalaField;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class FroalaFieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-froala-field', __DIR__.'/../dist/js/field.js');
            Nova::style('nova-froala-field', __DIR__.'/../dist/css/field.css');
        });

        $this->publishes([
            __DIR__.'/../dist/fonts/' => public_path('vendor/nova/fonts'),
        ], 'nova-froala-field-fonts');

        $this->publishes([
            __DIR__.'/../dist/css/froala_styles.min.css' => public_path('css/vendor/froala_styles.min.css'),
        ], 'froala-styles');

        $this->publishes([
            __DIR__.'/../config/froala-field.php' => config_path('nova/froala-field.php'),
        ], 'config');

        if (! class_exists('CreateFroalaAttachmentTables')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__.'/../database/migrations/create_froala_attachment_tables.php.stub'
                => database_path('migrations/'.$timestamp.'_create_froala_attachment_tables.php'),
            ], 'migrations');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
