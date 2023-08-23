<?php

use App\Http\Controllers\EncaixeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
    return redirect('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/users', [UserController::class, 'index'])->middleware(['auth', 'verified','permission:users'])->name('users');
Route::get('/users/{id}', [UserController::class, 'show'])->middleware(['auth', 'verified','permission:users'])->name('users.show');
Route::put('/users/{user}', [UserController::class, 'update'])->middleware(['auth', 'verified','permission:users'])->name('users.update');

Route::get('/encaixe', [EncaixeController::class, 'index'])->middleware(['auth', 'verified','permission:encaixe'])->name('encaixe');
Route::get('/encaixes/{id}', [EncaixeController::class, 'show'])->middleware(['auth', 'verified','permission:encaixe'])->name('encaixes.show');
Route::delete('/encaixe/{id}', [EncaixeController::class, 'delete'])->middleware(['auth', 'verified','permission:encaixe'])->name('encaixe.delete');
Route::put('/encaixes/{id}', [EncaixeController::class, 'updateMovimento'])->middleware(['auth', 'verified','permission:encaixe'])->name('encaixes.update');
Route::post('/encaixe', [EncaixeController::class, 'addEncaixe'])->middleware(['auth', 'verified','permission:encaixe'])->name('encaixe.add');
Route::post('/encaixeMovimento', [EncaixeController::class, 'addMovimento'])->middleware(['auth', 'verified','permission:encaixe'])->name('encaixeMovimento.add');
Route::delete('/encaixeMovimento/{id}', [EncaixeController::class, 'deletarMovimento'])->middleware(['auth', 'verified','permission:encaixe'])->name('encaixeMovimento.delete');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
