<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\almacenamientoController;
use App\Http\Controllers\Admin\InventarioController;

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

// Listados
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/usuarios/listado', [UserController::class, 'listado'])->name('admin.listado');
    Route::get('/admin/roles/listado', [UserController::class, 'listado'])->name('admin.roles');
    Route::get('/admin/almacenamiento/data', [almacenamientoController::class, 'data'])->name('admin.data');
    Route::get('/admin/inventario/data', [InventarioController::class, 'data'])->name('admin.inventario.datos');
});


// CRUD usuarios
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/usuarios', [UserController::class, 'index'])->name('admin.usuarios');
    Route::post('/admin/usuarios/store', [UserController::class, 'store'])->name('usuarios.store');
    Route::put('/admin/usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/admin/usuarios/{user}', [UserController::class, 'destroy'])->name('usuarios.destroy');
});

// CRUD almacenamiento
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/almacenamiento', [almacenamientoController::class, 'index'])->name('admin.almacenamiento');
    Route::post('/almacenamiento/store', [almacenamientoController::class, 'store'])->name('almacenamiento.store');
    Route::put('/almacenamiento/update/{user}', [almacenamientoController::class, 'update'])->name('almacenamiento.update');
    Route::delete('/almacenamiento/destroy/{id}', [almacenamientoController::class, 'destroy'])->name('almacenamiento.destroy');
});

// CRUD inventario
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/inventario', [InventarioController::class, 'index'])->name('admin.inventario');
    Route::post('/inventario/store', [InventarioController::class, 'store'])->name('inventario.store');
    Route::put('/inventario/update/{id}', [InventarioController::class, 'update'])->name('inventario.update');
    Route::delete('/inventario/destroy/{id}', [InventarioController::class, 'destroy'])->name('inventario.destroy');
});

require __DIR__ . '/auth.php';
