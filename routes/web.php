<?php

use App\Http\Controllers\DeckController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\LearningController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/dashboard', [DeckController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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
    Route::get('/{deck}/edit', [DeckController::class, 'edit'])->name('edit');
    Route::put('/{deck}', [DeckController::class, 'update'])->name('update');
    Route::delete('/{deck}', [DeckController::class, 'destroy'])->name('destroy');
    Route::get('/{deck}/show', [DeckController::class, 'show'])->name('show');

});

//カード管理
Route::prefix('decks/{deck}')->group(function () {
    Route::match(['get', 'post'], 'cards/create', [CardController::class, 'create'])->name('cards.create');
    Route::post('cards', [CardController::class, 'store'])->name('cards.store');
    Route::get('cards/{card}/edit', [CardController::class, 'edit'])->name('cards.edit');
    Route::put('cards/{card}', [CardController::class, 'update'])->name('cards.update');
    Route::delete('cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy');
    // 学習開始ページ
    Route::get('learning', [LearningController::class, 'start'])->name('learning.start');
    // 次のカードに進む
    Route::post('learning/next', [LearningController::class, 'next'])->name('learning.next');
});

Route::post('/learning/next/{deck}', [LearningController::class, 'nextCard'])->name('learning.next');




Route::get('/debug', function () {
    phpinfo();
});



require __DIR__.'/auth.php';
