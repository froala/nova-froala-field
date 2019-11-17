<?php

namespace Froala\NovaFroalaField\Http\Controllers;

use Laravel\Nova\Http\Controllers\TrixAttachmentController;
use Laravel\Nova\Http\Requests\NovaRequest;

class FroalaToTrixAttachmentAdapterController extends TrixAttachmentController
{
    /**
     * Store an attachment for a Trix field.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NovaRequest $request)
    {
        $response = parent::store($request);

        return $response->setData([
            'link' => $response->getData()->url,
        ]);
    }
}
