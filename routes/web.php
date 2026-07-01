<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\ProfesionalController;
use App\Http\Controllers\RecepcionistaController;
use App\Models\Profesional;
use App\Models\Recepcionista;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\ServicioController;


Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/turnos', [TurnoController::class, 'create'])->name('turnos');
Route::get('/turnos/ocupados', [TurnoController::class, 'obtenerOcupados'])->name('turnos.ocupados');
Route::post('/turnos', [TurnoController::class, 'store'])->name('turnos.store');

Route::get('/servicios', function () {
    return view('servicios');
})->name('servicios');

Route::redirect('/registro', '/register');

Route::get('/login', [LoginController::class, 'create'])
    ->name('login');
Route::post('/login', [LoginController::class, 'store'])
    ->name('login.store');

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->name('register.store');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::get('admin/dashboard', function(){
    $totalRecepcionistas = \App\Models\Recepcionista::count();
    $totalProfesionales = \App\Models\Profesional::count();
    $profesionales = Profesional::all();
    $recepcionistas = Recepcionista::all();
   
    return view('admin.dashboard', compact('totalRecepcionistas', 'totalProfesionales', 'profesionales', 'recepcionistas'));
})->middleware(['auth'])->name('admin.dashboard');

Route::get('recepcionista/dashboard', [RecepcionistaController::class, 'dashboard'])
    ->middleware(['auth'])->name('recepcionista.dashboard');

Route::resource('profesionales', ProfesionalController::class)
    ->middleware(['auth']);
Route::resource('recepcionistas', RecepcionistaController::class)
    ->middleware(['auth']);
    
Route::get('/perfil', function() {
    $turnos = \App\Models\Turno::where('user_id', auth()->id())
        ->with(['servicio', 'profesional']) // ◄ Corregido a español para que coincida con tu base de datos
        ->orderBy('fecha', 'asc')
        ->orderBy('hora', 'asc')
        ->get();

    $proximos = $turnos->where('fecha', '>=', now()->format('Y-m-d'));
    $historial = $turnos->where('fecha', '<', now()->format('Y-m-d'));

    return view('cliente.perfil', compact('proximos', 'historial'));
})->middleware('auth')->name('cliente.perfil');

// ⚙️ Rutas para que el Cliente Modifique o Cancele su propio turno
Route::middleware(['auth'])->group(function () {
    Route::get('/cliente/turnos/{id}/edit', [TurnoController::class, 'edit'])->name('cliente.turnos.edit');
    Route::put('/cliente/turnos/{id}', [TurnoController::class, 'update'])->name('cliente.turnos.update');
    Route::delete('/cliente/turnos/{id}', [TurnoController::class, 'cancel'])->name('cliente.turnos.cancel');
});


// Rutas para la gestión de Especialidades (Panel Admin)
Route::get('/admin/especialidades', [EspecialidadController::class, 'index'])->name('admin.especialidades.index');
Route::get('/admin/especialidades/{id}/edit', [EspecialidadController::class, 'edit'])->name('admin.especialidades.edit');
Route::put('/admin/especialidades/{id}', [EspecialidadController::class, 'update'])->name('admin.especialidades.update');
Route::post('/admin/especialidades/asignar', [EspecialidadController::class, 'asignar'])->name('admin.especialidades.asignar');
Route::post('/admin/especialidades', [EspecialidadController::class, 'store'])->name('admin.especialidades.store');

// Rutas para la gestión de Servicios
Route::get('/admin/servicios', [ServicioController::class, 'index'])->name('admin.servicios.index');
Route::post('/admin/servicios', [ServicioController::class, 'store'])->name('admin.servicios.store');
require __DIR__.'/auth.php';
