<?php

namespace Froala\NovaFroalaField\Handlers;

use Illuminate\Http\Request;

class DetachAttachment
{
    /**
     * The attachment model class name.
     *
     * @var string
     */
    protected $attachmentModelClassName;

    /**
     * Create a new class instance.
     *
     * @param  string $attachmentModelClassName
     * @return void
     */
    public function __construct($attachmentModelClassName)
    {
        $this->attachmentModelClassName = $attachmentModelClassName;
    }

    /**
     * Delete an attachment from the field.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        $this->attachmentModelClassName::where('url', $request->src)
                        ->get()
                        ->each
                        ->purge();
    }
}
