<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DelegateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('documents', DocumentController::class);
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('delegates', DelegateController::class);
    Route::get('/quetma', [DelegateController::class, 'add'])->name('delegates.add');
    Route::get('/manchieu', [DelegateController::class, 'slide'])->name('delegates.slide');
    Route::get('/delegates', [DelegateController::class, 'index'])->name('delegates');
});

Route::get('/vankien', [DocumentController::class, 'file'])->name('vankien');

Route::get('/thedaibieu', [DelegateController::class, 'searchForm'])->name('delegates.search.form');
Route::post('/thedaibieu', [DelegateController::class, 'search'])->name('delegates.search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
