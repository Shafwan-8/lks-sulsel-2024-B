<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

// Events
Route::get('/event', [EventController::class, 'index']);
Route::get('/event/detail/{id}', [EventController::class, 'show']);
Route::post('/event/register', [EventController::class, 'register']);
Route::post('/event/ticket', [EventController::class, 'show_ticket']);
Route::delete('/event/{id}', [EventController::class, 'destroy']);

// Destinasi
Route::get('/destinasi', [DestinationController::class, 'index']);
Route::get('/destinasi/{id}', [DestinationController::class, 'show']);

// Galleries
Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/galleries/{id}', [GalleryController::class, 'show']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

});
