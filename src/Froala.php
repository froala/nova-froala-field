<?php

namespace Froala\NovaFroalaField;

use Illuminate\Support\Str;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Symfony\Component\HttpFoundation\File\File;
use MadWeb\NovaFroalaEditor\Handlers\DetachAttachment;
use MadWeb\NovaFroalaEditor\Handlers\DeleteAttachments;
use MadWeb\NovaFroalaEditor\Handlers\AttachedImagesList;
use MadWeb\NovaFroalaEditor\Handlers\StorePendingAttachment;
use MadWeb\NovaFroalaEditor\Handlers\DiscardPendingAttachments;
use Laravel\Nova\Trix\PendingAttachment as TrixPendingAttachment;
use MadWeb\NovaFroalaEditor\Models\PendingAttachment as FroalaPendingAttachment;

class Froala extends Trix
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-froala-field';

    const DRIVER_NAME = 'froala';

    /** {@inheritdoc} */
    public function __construct(string $name, ?string $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta([
            'options' => [
                'toolbarButtons' => [
                    'bold',
                    'italic',
                    'underline',
                    '|',
                    'formatOL',
                    'formatUL',
                    '|',
                    'insertImage',
                    'insertFile',
                    'insertLink',
                    'insertVideo',
                    '|',
                    'embedly',
                    'spellChecker',
                    'html',
                ],
                'toolbarButtonsXS' => ['bold', 'italic', 'underline', '|', 'formatOL', 'formatUL'],
                'heightMin' => 300,
            ],
            'draftId' => Str::uuid(),
            'attachmentsDriver' => config('nova.froala-field.attachments_driver'),
        ]);
    }

    /**
     * Ability to pass any existing Froala options to the editor instance.
     * Refer to the Froala documentation {@link https://www.froala.com/wysiwyg-editor/docs/options}
     * to view a list of all available options.
     *
     * @param array $options
     * @return self
     */
    public function options(array $options)
    {
        return $this->withMeta([
            'options' => array_merge($this->meta['options'], $options),
        ]);
    }

    /**
     * Specify that file uploads should not be allowed.
     */
    public function withFiles($disk = null)
    {
        $this->withFiles = true;

        $this->disk($disk);

        if (config('nova.froala-field.attachments_driver', self::DRIVER_NAME) !== self::DRIVER_NAME) {

            return parent::withFiles($disk);
        }

        $this->attach(new StorePendingAttachment($this))
            ->detach(new DetachAttachment)
            ->delete(new DeleteAttachments($this))
            ->discard(new DiscardPendingAttachments)
            ->prunable();

        return $this;
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     */
    protected function fillAttribute(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if (isset($this->fillCallback)) {
            return call_user_func(
                $this->fillCallback,
                $request,
                $model,
                $attribute,
                $requestAttribute
            );
        }

        $this->fillAttributeFromRequest(
            $request,
            $requestAttribute,
            $model,
            $attribute
        );

        if ($request->{$this->attribute.'DraftId'} && $this->withFiles) {
            $pendingAttachmentClass =
                config('nova.froala-field.attachments_driver', self::DRIVER_NAME) === self::DRIVER_NAME
                ? FroalaPendingAttachment::class
                : TrixPendingAttachment::class;

            if ($model->exists) {
                $pendingAttachmentClass::persistDraft(
                    $request->{$this->attribute.'DraftId'},
                    $this,
                    $model
                );
            } else {
                $modelClass = get_class($model);

                $modelClass::saved(function ($model) use ($request, $pendingAttachmentClass) {
                    if ($model->wasRecentlyCreated) {
                        $pendingAttachmentClass::persistDraft(
                            $request->{$this->attribute.'DraftId'},
                            $this,
                            $model
                        );
                    }
                });
            }
        }
    }

    public function showOnIndex()
    {
        $this->showOnIndex = true;
    }
}
