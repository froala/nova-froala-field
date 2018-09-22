<?php

namespace Froala\NovaFroalaField\Tests;

use Illuminate\Support\Facades\Route;
use Froala\NovaFroalaField\FroalaFieldServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp()
    {
        parent::setUp();

        Route::middlewareGroup('nova', []);
    }

    protected function getPackageProviders($app)
    {
        return [
            FroalaFieldServiceProvider::class,
        ];
    }
}
