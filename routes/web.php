<?php

use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PivoteStockCarritoController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UsuarioController;
use App\Models\Pivote_stock_carrito;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::resource('carrito',CarritoController::class);
Route::resource('pago',PagoController::class);
Route::resource('pivote_stock_carrito',PivoteStockCarritoController::class);
Route::resource('stock',StockController::class);
Route::resource('usuario', UsuarioController::class);
Route::post('/usuario-login', [UsuarioController::class,'usuariologin'])->middleware('auth')->name('usuario.login');
Route::get('/usuario-login-vista',[UsuarioController::class,'obtenerVista'])->name('usuario-login-vista');

Route::view('\bienvenida','landing')->name('bienvenida');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
