<?php

namespace Froala\NovaFroalaField\Tests;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadsHelper
{
    protected $file;

    protected $draftId;

    public function setUp()
    {
        parent::setUp();

        Storage::fake(TestCase::DISK);

        $this->draftId = Str::uuid();

        $this->regenerateUpload();
    }

    protected function regenerateUpload()
    {
        $this->file = UploadedFile::fake()->image('picture'.random_int(1, 100).'.jpg');
    }

    /**
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function uploadPendingFile(): \Illuminate\Foundation\Testing\TestResponse
    {
        return $this->json('POST', 'nova-vendor/froala-field/articles/attachments/content', [
            'draftId' => $this->draftId,
            'attachment' => $this->file,
        ]);
    }

    /**
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function storeArticle(): \Illuminate\Foundation\Testing\TestResponse
    {
        return $this->json('POST', 'nova-api/articles', [
            'title' => 'Some title',
            'content' => 'Some content',
            'contentDraftId' => $this->draftId,
        ]);
    }
}
