<?php

namespace Froala\NovaFroalaField\Handlers;

use Illuminate\Http\Request;

class DiscardPendingAttachments
{
    /**
     * The pending attachment model class name.
     *
     * @var string
     * @psalm-var class-string<\Froala\NovaFroalaField\Models\PendingAttachment>
     */
    protected $pendingAttachmentModelClassName;

    /**
     * Create a new class instance.
     *
     * @param  string $pendingAttachmentModelClassName
     * @return void
     */
    public function __construct($pendingAttachmentModelClassName)
    {
        $this->pendingAttachmentModelClassName = $pendingAttachmentModelClassName;
    }

    /**
     * Discard pendings attachments on the field.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        $this->pendingAttachmentModelClassName::where('draft_id', $request->draftId)
                    ->get()
                    ->each
                    ->purge();
    }
}
