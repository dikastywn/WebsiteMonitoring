<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;

Route::get('/', [SensorController::class, 'index']);
Route::get('/api/sensor/latest', [SensorController::class, 'getLatestData']);
Route::get('/api/sensor/chart', [SensorController::class, 'getChartData']);

//tambahan
Route::get('/apistreak', [SensorController::class, 'index']);

//tambahan lagi eko
Route::get('/apistreak2', [SensorController::class, 'index']);
