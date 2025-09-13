<?php

use App\Http\Controllers\Web\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {;
    return view('welcome');
});
// Auth
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/register', [PageController::class, 'register']);

// Servers
Route::get('/servers', [PageController::class, 'servers']);
Route::get('/servers/create', [PageController::class, 'createServer']);
Route::get('/servers/{id}/edit', [PageController::class, 'editServer']);
