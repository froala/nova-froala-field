<?php

namespace Froala\NovaFroalaField\Tests;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Froala\NovaFroalaField\Models\PendingAttachment;

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

        $response->assertJson(['link' => Storage::disk(static::DISK)->url($this->file->getClientOriginalName())]);

        $this->assertDatabaseHas((new PendingAttachment)->getTable(), [
            'draft_id' => $this->draftId,
            'disk' => static::DISK,
            'attachment' => $this->file->getClientOriginalName(),
        ]);

        // Assert the file was stored...
        Storage::disk(static::DISK)->assertExists($this->file->getClientOriginalName());
    }

    /** @test */
    public function same_filename_error()
    {
        $this->uploadPendingFile();

        $response = $this->uploadPendingFile();

        $response->assertStatus(Response::HTTP_CONFLICT);
    }
}
