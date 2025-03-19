<?php

use App\Http\Controllers\DeckController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

//デッキ管理
Route::prefix('decks')->name('decks.')->group(function () {
    Route::get('/', [DeckController::class, 'index'])->name('index');
    Route::get('/create', [DeckController::class, 'create'])->name('create');
    Route::post('/store', [DeckController::class, 'store'])->name('store');
});


require __DIR__.'/auth.php';
