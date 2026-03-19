<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NumbersController;

Route::prefix('numbers')->group(function () {
    Route::post('/', [NumbersController::class, 'store']);
    Route::get('/', [NumbersController::class, 'pop']);
});
