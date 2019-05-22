<?php

use Illuminate\Support\Facades\Route;
use Froala\NovaFroalaField\Http\Controllers\FroalaUploadController;
use Froala\NovaFroalaField\Http\Controllers\FroalaImageManagerController;

Route::get('{resource}/image-manager', FroalaImageManagerController::class.'@index');
Route::delete('{resource}/image-manager', FroalaImageManagerController::class.'@destroy');

Route::post('{resource}/attachments/{field}', FroalaUploadController::class.'@store');
Route::delete('{resource}/attachments/{field}', FroalaUploadController::class.'@destroyAttachment');
Route::delete('{resource}/attachments/{field}/{draftId}', FroalaUploadController::class.'@destroyPending');
