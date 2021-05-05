<?php

namespace Froala\NovaFroalaField\Tests;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PreserveFilenamesTest extends TestCase
{
    use UploadsHelper {
        setUp as uplaodsSetUp;
    }

    public function setUp(): void
    {
        $this->uplaodsSetUp();

        $this->app['config']->set('nova.froala-field.preserve_file_names', true);
    }

    /** @test */
    public function save_image()
    {
        $response = $this->uploadPendingFile();

        $response->assertJson(['link' => Storage::disk(static::DISK)->url($this->getAttachmentLocation(true))]);

        $this->assertDatabaseHas($this->getPendingAttachmentsTable(), [
            'draft_id' => $this->draftId,
            'disk' => static::DISK,
            'attachment' => $this->getAttachmentLocation(true),
        ]);

        // Assert the file was stored...
        Storage::disk(static::DISK)->assertExists($this->getAttachmentLocation(true));
    }

    /** @test */
    public function same_filename_error()
    {
        $this->uploadPendingFile();

        $response = $this->uploadPendingFile();

        $response->assertStatus(Response::HTTP_CONFLICT);
    }
}
