<?php

namespace Froala\NovaFroalaField\Tests;

use Illuminate\Support\Facades\Storage;

class FroalaImageManagerControllerTest extends TestCase
{
    use UploadsHelper;

    /** @test */
    public function get_images()
    {
        $images = [];

        for ($i = 0; $i <= 10; $i++) {
            $this->uploadPendingFile();

            $url = Storage::disk(TestCase::DISK)->url($this->file->hashName());

            $images[] = [
                'url' => $url,
                'thumb' => $url,
            ];

            $this->regenerateUpload();
        }

        $response = $this->get('nova-vendor/froala-field/articles/image-manager?field=content');

        usort($images, function ($a, $b) {
            return strcasecmp($a['url'], $b['url']);
        });

        $response->assertJson($images);
    }

    /** @test */
    public function destroy_image()
    {
        $src = $this->uploadPendingFile()->json('link');

        $this->storeArticle();

        $this->json('DELETE', 'nova-vendor/froala-field/articles/image-manager', [
            'src' => $src,
            'field' => 'content',
        ]);

        Storage::disk(static::DISK)->assertMissing($this->file->hashName());
    }
}
