<?php

namespace Froala\NovaFroalaField\Tests\Fixtures;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Relation::morphMap([
            'article' => Article::class,
        ]);
    }
}
