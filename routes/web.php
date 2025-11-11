<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;

Route::get('/', [SensorController::class, 'index']);
Route::get('/api/sensor/latest', [SensorController::class, 'getLatestData']);
Route::get('/api/sensor/chart', [SensorController::class, 'getChartData']);
