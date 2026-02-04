<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminPollController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);

// Polls for all
Route::get('/polls', [PollController::class, 'index'])->name('polls.index');
Route::get('/polls/{poll}', [PollController::class, 'show'])->name('polls.show');
Route::post('/polls/{poll}/vote', [PollController::class, 'vote'])->name('polls.vote');

// Member dashboard (authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/', [AdminPollController::class, 'index'])->name('admin.polls.index');
    Route::get('/polls/create', [AdminPollController::class, 'create'])->name('admin.polls.create');
    Route::post('/polls', [AdminPollController::class, 'store'])->name('admin.polls.store');
    Route::get('/polls/{poll}/edit', [AdminPollController::class, 'edit'])->name('admin.polls.edit');
    Route::put('/polls/{poll}', [AdminPollController::class, 'update'])->name('admin.polls.update');
    Route::delete('/polls/{poll}', [AdminPollController::class, 'destroy'])->name('admin.polls.destroy');
    Route::get('/polls/{poll}/results', [AdminPollController::class, 'results'])->name('admin.polls.results');
});
