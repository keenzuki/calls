<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CallsController;
use App\Http\Controllers\CustomerController;
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
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('calls/calls', [CustomerController::class, 'index'])->name('makecall');
    Route::post('calls/search', [CallsController::class, 'search']);
    Route::post('Calls/upload', [CallsController::class, 'import'])->name('upload');
    Route::post('calls/callupdate', [CallsController::class, 'callupdate'])->name('callupdate');

});

require __DIR__.'/auth.php';
