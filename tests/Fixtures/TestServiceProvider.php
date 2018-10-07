<?php

namespace Froala\NovaFroalaField\Tests\Fixtures;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app['config']->set('nova.froala-field.attachments_driver', 'trix');
    }
}
