<?php

use App\Http\Controllers\HardwareController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetricController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    return $request->user();
});

Route::post('/metrics', [MetricController::class, 'store'])->middleware('auth:sanctum');
Route::post('/specs', [HardwareController::class, 'store'])->middleware('auth:sanctum');