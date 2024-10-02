<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DelegateController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PhotoController;
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

Route::middleware(['auth', 'verified'])->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
  Route::resource('photo', PhotoController::class);
  Route::get('/photo', [PhotoController::class, 'index'])->name('photo');
});

Route::get('/hinhanh', [PhotoController::class, 'gallery'])->name('galleries');
// Route::get('/hinhanh_andien', [GalleryController::class, 'an_dien'])->name('an_dien');
// Route::get('/hinhanh_chanhphuhoa', [GalleryController::class, 'chanh_phu_hoa'])->name('chanh_phu_hoa');
// Route::get('/hinhanh_hoaloi', [GalleryController::class, 'hoa_loi'])->name('hoa_loi');
// Route::get('/hinhanh_myphuoc', [GalleryController::class, 'my_phuoc'])->name('my_phuoc');
// Route::get('/hinhanh_phuan', [GalleryController::class, 'phu_an'])->name('phu_an');
// Route::get('/hinhanh_antay', [GalleryController::class, 'an_tay'])->name('an_tay');
// Route::get('/hinhanh_tandinh', [GalleryController::class, 'tan_dinh'])->name('tan_dinh');

Route::get('/vankien', [DocumentController::class, 'file'])->name('vankien');

Route::get('/thedaibieu', [DelegateController::class, 'searchForm'])->name('delegates.search.form');
Route::post('/thedaibieu', [DelegateController::class, 'search'])->name('delegates.search');

require __DIR__.'/auth.php';
