<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;

Route::controller(PublicController::class)->name('public.')->group(function () {
    Route::get('/', 'index')->name('home');
});