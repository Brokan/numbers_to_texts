<?php

use App\Http\Controllers\Api\NumbersController;
use Illuminate\Support\Facades\Route;

Route::prefix('numbers')->group(function () {
    Route::post('/', [NumbersController::class, 'store']);
    Route::get('/', [NumbersController::class, 'pop']);
});
