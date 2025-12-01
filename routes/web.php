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
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/pdfejemplo', function () {
    // Datos de ejemplo para mostrar el ticket
    $items = [
        ['name' => 'Camisa deportiva', 'qty' => 1, 'price' => 199.99],
        ['name' => 'Pantalón', 'qty' => 2, 'price' => 89.50],
        ['name' => 'Calcetines', 'qty' => 3, 'price' => 5.00],
    ];

    $pdf = Pdf::loadView('PDF.pdf', [
        'items' => $items,
        'orderId' => 'TCK-1001',
        'date' => date('d/m/Y H:i'),
        'storeName' => 'Tienda Ejemplo',
        'storeAddress' => 'Av. Central 10',
        'storePhone' => '555-1234',
        'tax' => 0,
    ]);

    return $pdf->stream('ticket.pdf'); // para mostrar en el navegador
    // return $pdf->download('archivo.pdf'); para descargar el archivo
});
/* 
Route::get('/pdf-usuario', function () {
    $usuario = [
        'nombre' => 'David',
        'edad' => 21
        ///CAMBIAR POR DATOS DESPUES
    ];

    $pdf = Pdf::loadView('pdf.ejemplo', compact('usuario'));

    return $pdf->download('usuario.pdf');
});
*/

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::resource('carrito',CarritoController::class);
Route::post('carrito/{carrito}/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::post('carrito/agregar-usuario', [CarritoController::class, 'agregarAlUsuario'])
    ->name('carrito.agregar.usuario');
Route::post('carrito/guest/remove', [CarritoController::class, 'removeGuestItem'])->name('carrito.guest.remove');
// Ruta específica para generar PDF debe registrarse antes del resource
Route::get('pago/generar-pdf', [PagoController::class, 'generarPdf'])->name('pago.generar.pdf');
Route::resource('pago',PagoController::class);
Route::resource('pivote_stock_carrito',PivoteStockCarritoController::class);
Route::resource('stock',StockController::class);
Route::resource('usuario', UsuarioController::class);
Route::post('/usuario-login', [UsuarioController::class,'usuariologin'])->name('usuario.login');
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
