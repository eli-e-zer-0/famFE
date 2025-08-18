<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

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
});

Route::get('/almacenamiento', function () {
    return view('vistas.almacenamiento.almacenamiento');
})->name('almacenamiento');

// CRUD usuarios
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/usuarios', [UserController::class, 'index'])->name('admin.usuarios');
    Route::post('/admin/usuarios/store', [UserController::class, 'store'])->name('usuarios.store');
    Route::put('/admin/usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/admin/usuarios/{user}', [UserController::class, 'destroy'])->name('usuarios.destroy');
});

require __DIR__.'/auth.php';
