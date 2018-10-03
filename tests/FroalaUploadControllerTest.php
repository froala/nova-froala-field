<?php

namespace Froala\NovaFroalaField\Tests;

class FroalaUploadControllerTest extends TestCase
{
    /** @test */
    public function it_can_can_return_a_response()
    {
        $this
            ->get('nova-vendor/froala-field/attachments')
            ->assertSuccessful();
    }
}
