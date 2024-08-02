<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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
Route::get('/',[BlogController::class, 'index']);

Route::get('/dashboard',[PostController::class, 'index'])->middleware(['auth', 'verified','role:admin'])->name('dashboard');
Route::resource('posts', PostController::class)->middleware(['auth','role:admin']);
Route::resource('blogs', BlogController::class);
Route::get('blogs/category/{id}', [BlogController::class, 'showCategory'])->name('blogs.category');


Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
