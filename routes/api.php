<?php

use Illuminate\Support\Facades\Route;
use MadWeb\NovaFroalaEditor\Http\Controllers\FroalaUploadController;
use MadWeb\NovaFroalaEditor\Http\Controllers\FroalaImageManagerController;

Route::get('image-manager', FroalaImageManagerController::class.'@index');
Route::delete('image-manager', FroalaImageManagerController::class.'@destroy');

Route::post('{resource}/attachments/{field}', FroalaUploadController::class.'@store');
Route::delete('{resource}/attachments/{field}', FroalaUploadController::class.'@destroyAttachment');
Route::delete('{resource}/attachments/{field}/{draftId}', FroalaUploadController::class.'@destroyPending');
