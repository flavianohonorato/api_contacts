<?php

use App\Http\Controllers\Api\V1\ContactsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('contacts', ContactsController::class);
});
