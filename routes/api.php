<?php

use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\TicketStatisticsController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/tickets', [TicketController::class, 'store']);
Route::get('/tickets/statistics', [TicketStatisticsController::class, 'index']);