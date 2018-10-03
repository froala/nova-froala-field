<?php

namespace Froala\NovaFroalaField\Handlers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Froala\NovaFroalaField\Froala;
use Illuminate\Support\Facades\Storage;
use Froala\NovaFroalaField\Models\PendingAttachment;

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
                    '/',
                    $request->attachment->getClientOriginalName(),
                    $this->field->disk
                ) : $request->attachment->store('/', $this->field->disk),
            'disk' => $this->field->disk,
        ])->attachment;

        return Storage::disk($this->field->disk)->url($attachment);
    }

    protected function abortIfFileNameExists(Request $request): void
    {
        if (config('nova.froala-field.preserve_file_names')
            && Storage::disk($this->field->disk)
                ->exists($request->attachment->getClientOriginalName())
        ) {
            abort(response()->json([
                'status' => Response::HTTP_CONFLICT,
            ]), Response::HTTP_CONFLICT);
        }
    }
}
