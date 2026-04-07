<?php

use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\WidgetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });

Route::get('/widget', [WidgetController::class, 'show'])->name('widget.show');

Route::middleware(['auth', 'role:admin|manager'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/ticks', [AdminTicketController::class, 'index'])->name('ticks.index');
        Route::get('/ticks/{ticket}', [AdminTicketController::class, 'show'])->name('ticks.show');
        Route::patch('/ticks/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('ticks.status');
    });