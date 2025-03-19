<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::get('/', [TicketController::class, 'index']);
Route::get('/ticket/create', [TicketController::class, 'create']);
Route::post('/ticket/store', [TicketController::class, 'store']);
Route::get('/ticket/{id}/edit', [TicketController::class, 'edit']);
Route::post('/ticket/{id}/update', [TicketController::class, 'update']);
Route::post('/ticket/{id}/delete', [TicketController::class, 'destroy']);
