<?php

namespace Froala\NovaFroalaField\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
    ];

    public $timestamps = false;
}
