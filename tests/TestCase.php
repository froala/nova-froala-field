<?php

namespace Froala\NovaFroalaField\Tests;

use Froala\NovaFroalaField\FroalaFieldServiceProvider;
use Froala\NovaFroalaField\Tests\Fixtures\TestResource;
use Froala\NovaFroalaField\Tests\Fixtures\TestServiceProvider;
use Froala\NovaFroalaField\Tests\Fixtures\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\NovaCoreServiceProvider;
use Laravel\Nova\NovaServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    const DISK = 'public';

    const PATH = 'subpath';

    public static $user;

    public function setUp(): void
    {
        parent::setUp();

        Route::middlewareGroup('nova', []);

        $this->setUpDatabase($this->app);

        Nova::resources([
            TestResource::class,
        ]);

        self::$user = self::$user ?? User::create([
            'name' => 'Test User',
            'email' => 'test@user.com',
            'password' => 'secret',
        ]);

        $this->actingAs(self::$user);
    }

    protected function getPackageProviders($app)
    {
        return [
            NovaCoreServiceProvider::class,
            NovaServiceProvider::class,
            NovaApplicationServiceProvider::class,
            FroalaFieldServiceProvider::class,
            TestServiceProvider::class,
        ];
    }

    /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $this->artisan('migrate:fresh');

        include_once __DIR__.'/../database/migrations/create_froala_attachment_tables.php.stub';

        (new \CreateFroalaAttachmentTables())->up();

        $app['db']->connection()->getSchemaBuilder()->create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('content');
        });

        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
        });
    }
}
