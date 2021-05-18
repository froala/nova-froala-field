<?php

namespace Froala\NovaFroalaField\Handlers;

use Illuminate\Http\Request;

class DeleteAttachments
{
    /**
     * The field instance.
     *
     * @var \Froala\NovaFroalaField\Froala
     */
    public $field;

    /**
     * The attachment model class name.
     *
     * @var string
     */
    protected $attachmentModelClassName;

    /**
     * Create a new class instance.
     *
     * @param  \Froala\NovaFroalaField\Froala  $field
     * @param  string $attachmentModelClassName
     * @return void
     */
    public function __construct($field, $attachmentModelClassName)
    {
        $this->field = $field;
        $this->attachmentModelClassName = $attachmentModelClassName;
    }

    /**
     * Delete the attachments associated with the field.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $model
     * @return array
     */
    public function __invoke(Request $request, $model)
    {
        $this->attachmentModelClassName::where('attachable_type', get_class($model))
                ->where('attachable_id', $model->getKey())
                ->get()
                ->each
                ->purge();

        return [$this->field->attribute => ''];
    }
}
