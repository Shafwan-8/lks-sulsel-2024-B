<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

// Events
Route::get('/event', [EventController::class, 'index']);
Route::get('/event/detail/{id}', [EventController::class, 'show']);
Route::post('/event/register', [EventController::class, 'register']);
Route::post('/event/ticket', [EventController::class, 'show_ticket']);

// Destinasi
Route::get('/destinasi', [DestinationController::class, 'index']);
Route::get('/destinasi/detail/{id}', [DestinationController::class, 'show']);

// Galleries
Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/galleries/detail/{id}', [GalleryController::class, 'show']);

// Post
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/detail/{id}', [PostController::class, 'show']);


Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);

    // Event
    Route::get('/admin/event', [EventController::class, 'index']);
    Route::get('/admin/event/{id}', [EventController::class, 'show']);
    Route::post('/admin/event/create', [EventController::class, 'create']);
    Route::put('/admin/event/{id}', [EventController::class, 'edit']);
    Route::delete('/admin/event/{id}', [EventController::class, 'destroy']);

    // Destination
    Route::post('/admin/destination/create', [DestinationController::class, 'create']);
    Route::get('/admin/destination/{id}', [DestinationController::class, 'show']);
    Route::put('/admin/destination/{id}', [DestinationController::class, 'update']);
    Route::delete('/admin/destination/{id}', [DestinationController::class, 'destroy']);

    // Post
    Route::get('/admin/post', [PostController::class, 'index']);
    Route::get('/admin/post/{id}', [PostController::class, 'show']);
    Route::post('/admin/post/create', [PostController::class, 'create']);
    Route::put('/admin/post/{id}', [PostController::class, 'edit']);
    Route::delete('/admin/post/{id}', [PostController::class, 'destroy']);

    // Galleries
    Route::get('/admin/gallery', [GalleryController::class, 'index']);
    Route::get('/admin/gallery/{id}', [GalleryController::class, 'show']);
    Route::post('/admin/gallery/create', [GalleryController::class, 'create']);
    Route::put('/admin/gallery/{id}', [GalleryController::class, 'update']);
    Route::delete('/admin/gallery/{id}', [GalleryController::class, 'destroy']);

    // Categories
    Route::get('/admin/category', [CategoryController::class, 'index']);

});
