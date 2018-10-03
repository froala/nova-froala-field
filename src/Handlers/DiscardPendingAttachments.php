<?php

namespace Froala\NovaFroalaField\Handlers;

use Illuminate\Http\Request;
use Froala\NovaFroalaField\Models\PendingAttachment;

class DiscardPendingAttachments
{
    /**
     * Discard pendings attachments on the field.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        PendingAttachment::where('draft_id', $request->draftId)
                    ->get()
                    ->each
                    ->purge();
    }
}
