<?php

namespace Froala\NovaFroalaField\Jobs;

class PruneStaleAttachments
{
    /**
     * Prune the stale attachments from the system.
     *
     * @return void
     */
    public function __invoke()
    {
        $pendingAttachmentModelClassName = config('nova.froala-field.pending_attachment_model');

        $pendingAttachmentModelClassName::where('created_at', '<=', now()->subDays(1))
                    ->orderBy('id', 'desc')
                    ->chunk(100, function ($attachments) {
                        $attachments->each->purge();
                    });
    }
}
