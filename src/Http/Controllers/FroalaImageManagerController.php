<?php

namespace Froala\NovaFroalaField\Http\Controllers;

use Froala\NovaFroalaField\Froala;
use Laravel\Nova\Http\Requests\NovaRequest;

class FroalaImageManagerController
{
    public function index(NovaRequest $request)
    {
        $field = $request->newResource()
            ->availableFields($request)
            ->findFieldByAttribute($request->field, function () {
                abort(404);
            });

        return call_user_func(
            $field->imagesCallback,
            $request
        );
    }

    public function destroy(NovaRequest $request)
    {
        if (config('nova.froala-field.attachments_driver') !== Froala::DRIVER_NAME) {
            $request->replace(['attachmentUrl' => $request->input('src')] + $request->except('src'));
        }

        $field = $request->newResource()
            ->availableFields($request)
            ->findFieldByAttribute($request->field, function () {
                abort(404);
            });

        call_user_func(
            $field->detachCallback,
            $request
        );
    }
}
