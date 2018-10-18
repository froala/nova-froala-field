<?php

namespace Froala\NovaFroalaField\Tests\Fixtures;

use Laravel\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Froala\NovaFroalaField\Froala;
use Froala\NovaFroalaField\Tests\TestCase;

class TestResource extends Resource
{
    public static $model = Article::class;

    public static function uriKey()
    {
        return 'articles';
    }

    public function fields(Request $request)
    {
        return [
            Text::make('Title'),
            Froala::make('Content')->withFiles(TestCase::DISK),
        ];
    }
}
