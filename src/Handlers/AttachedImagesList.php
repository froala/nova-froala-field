<?php

namespace Froala\NovaFroalaField\Handlers;

use Froala\NovaFroalaField\Froala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachedImagesList
{
    /**
     * The field instance.
     *
     * @var \Froala\NovaFroalaField\Froala
     */
    public $field;

    /**
     * Create a new invokable instance.
     *
     * @param  \Froala\NovaFroalaField\Froala  $field
     * @return void
     */
    public function __construct(Froala $field)
    {
        $this->field = $field;
    }

    /**
     * Attach a pending attachment to the field.
     */
    public function __invoke(Request $request): array
    {
        $images = [];

        $Storage = Storage::disk($this->field->disk);

        foreach ($Storage->allFiles() as $file) {
            if (! app()->runningUnitTests() and ! @getimagesize($Storage->url($file))) {
                continue;
            }

            $url = $Storage->url($file);
            $images[] = [
                'url' => $url,
                'thumb' => $url,
            ];
        }

        return $images;
    }
}
