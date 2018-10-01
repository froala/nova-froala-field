<?php

namespace Froala\NovaFroalaField;

use Illuminate\Support\Str;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Trix\PendingAttachment;
use Laravel\Nova\Http\Requests\NovaRequest;

class Froala extends Trix
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-froala-field';

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
            if ($model->exists) {
                PendingAttachment::persistDraft(
                    $request->{$this->attribute.'DraftId'},
                    $this,
                    $model
                );
            } else {
                $modelClass = get_class($model);

                $modelClass::saved(function ($model) use ($request) {
                    if ($model->wasRecentlyCreated) {
                        PendingAttachment::persistDraft(
                            $request->{$this->attribute.'DraftId'},
                            $this,
                            $model
                        );
                    }
                });
            }
        }
    }
}
