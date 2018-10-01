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
