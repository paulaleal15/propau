<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PerfilController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PedidoController;

Route::get('/', [WebController::class, 'index'])->name('web.index');
Route::get('/habitaciones', [WebController::class, 'habitaciones'])->name('web.habitaciones');
Route::get('/conocenos', [WebController::class, 'conocenos'])->name('web.conocenos');
Route::get('/producto/{id}', [WebController::class, 'show'])->name('web.show');

Route::get('/carrito', [CarritoController::class, 'mostrar'])->name('carrito.mostrar');
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::post('/carrito/actualizar-huespedes', [CarritoController::class, 'actualizarHuespedes'])->name('carrito.actualizarHuespedes');
Route::get('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::get('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');

Route::middleware(['auth'])->group(function(){
    Route::resource('usuarios', UserController::class);
    Route::patch('usuarios/{usuario}/toggle', [UserController::class, 'toggleStatus'])->name('usuarios.toggle');
    Route::resource('roles', RoleController::class);
    Route::resource('productos', ProductoController::class);

    Route::get('/pago', [PedidoController::class, 'mostrarPago'])->name('pago.mostrar');
    Route::post('/pago/procesar', [PedidoController::class, 'procesarPago'])->name('pago.procesar');
    Route::get('/perfil/pedidos', [PedidoController::class, 'index'])->name('perfil.pedidos');

    Route::get('dashboard', function(){
        return view('dashboard');
    })->name('dashboard');

    Route::post('logout', function(){
        Auth::logout();
        return redirect('/login');
    })->name('logout');

    Route::get('/perfil', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
});

Route::middleware('guest')->group(function(){
    Route::get('login', function(){
        return view('autenticacion.login');
    })->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/registro', [RegisterController::class, 'showRegistroForm'])->name('registro');
    Route::post('/registro', [RegisterController::class, 'registrar'])->name('registro.store');

    Route::get('password/reset', [ResetPasswordController::class, 'showRequestForm'])->name('password.request');
    Route::post('password/email', [ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.send-link');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'resetPassword'])->name('password.update');

});

