<?php

namespace Froala\NovaFroalaField\Handlers;

use Froala\NovaFroalaField\Froala;
use Froala\NovaFroalaField\Models\PendingAttachment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class StorePendingAttachment
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function __invoke(Request $request)
    {
        $this->abortIfFileNameExists($request);

        $attachment = PendingAttachment::create([
            'draft_id' => $request->draftId,
            'attachment' => config('nova.froala-field.preserve_file_names')
                ? $request->attachment->storeAs(
                    $this->field->getStorageDir(),
                    $request->attachment->getClientOriginalName(),
                    $this->field->disk
                ) : $request->attachment->store($this->field->getStorageDir(), $this->field->disk),
            'disk' => $this->field->disk,
        ])->attachment;

        $this->imageOptimize($attachment);

        return Storage::disk($this->field->disk)->url($attachment);
    }

    protected function abortIfFileNameExists(Request $request): void
    {
        $path = rtrim($this->field->getStorageDir(), '/').'/'.$request->attachment->getClientOriginalName();

        if (config('nova.froala-field.preserve_file_names')
            && Storage::disk($this->field->disk)
                ->exists($path)
        ) {
            abort(response()->json([
                'status' => Response::HTTP_CONFLICT,
            ], Response::HTTP_CONFLICT));
        }
    }

    protected function imageOptimize(string $attachment): void
    {
        if (config('nova.froala-field.optimize_images')) {
            $optimizerChain = OptimizerChainFactory::create();

            if (count($optimizers = config('nova.froala-field.image_optimizers'))) {
                $optimizers = array_map(
                    function (array $optimizerOptions, string $optimizerClassName) {
                        return (new $optimizerClassName)->setOptions($optimizerOptions);
                    },
                    $optimizers,
                    array_keys($optimizers)
                );

                $optimizerChain->setOptimizers($optimizers);
            }

            $optimizerChain->optimize(Storage::disk($this->field->disk)->path($attachment));
        }
    }
}
