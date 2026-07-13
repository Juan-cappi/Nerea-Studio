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

Route::get('/servicios', function () {
    return view('servicios');
})->name('servicios');

Route::get('/nosotros' , function() {
    return view('nosotros');
})->name('nosotros');

Route::get('/turnos', [TurnoController::class, 'create'])->name('turnos');
Route::get('/turnos/ocupados', [TurnoController::class, 'obtenerOcupados'])->name('turnos.ocupados');
Route::post('/turnos', [TurnoController::class, 'store'])->middleware('auth')->name('turnos.store');


Route::redirect('/registro', '/register');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');


Route::middleware(['auth'])->group(function () {

    Route::view('dashboard', 'dashboard')->middleware(['verified'])->name('dashboard');

    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // Perfil e historial del cliente
    Route::get('/perfil', function() {
        $hoy = now()->format('Y-m-d');

        $proximos = \App\Models\Turno::where('user_id', auth()->id())
            ->where('fecha', '>=', $hoy)
            ->with(['elServicio', 'elProfesional'])
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->paginate(5, ['*'], 'pag_prox')
            ->withQueryString();

        $historial = \App\Models\Turno::where('user_id', auth()->id())
            ->where('fecha', '<', $hoy)
            ->with(['elServicio', 'elProfesional'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->paginate(5, ['*'], 'pag_hist')
            ->withQueryString();

        return view('cliente.perfil', compact('proximos', 'historial'));
    })->name('cliente.perfil');

    // Gestión de turnos propios del cliente
    Route::get('/cliente/turnos/{id}/edit', [TurnoController::class, 'edit'])->name('cliente.turnos.edit');
    Route::put('/cliente/turnos/{id}', [TurnoController::class, 'update'])->name('cliente.turnos.update');
    Route::delete('/cliente/turnos/{id}', [TurnoController::class, 'cancel'])->name('cliente.turnos.cancel');
});


Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('admin/dashboard', function(){
        $totalRecepcionistas = \App\Models\Recepcionista::count();
        $totalProfesionales  = \App\Models\Profesional::count();

        $profesionales  = Profesional::orderBy('nombre')
            ->paginate(5, ['*'], 'pag_prof')
            ->withQueryString();

        $recepcionistas = Recepcionista::orderBy('nombre')
            ->paginate(5, ['*'], 'pag_recep')
            ->withQueryString();

        return view('admin.dashboard', compact('totalRecepcionistas', 'totalProfesionales', 'profesionales', 'recepcionistas'));
    })->name('admin.dashboard');

    Route::resource('profesionales', ProfesionalController::class);
    Route::resource('recepcionistas', RecepcionistaController::class);

    Route::get('/admin/especialidades', [EspecialidadController::class, 'index'])->name('admin.especialidades.index');
    Route::get('/admin/especialidades/{id}/edit', [EspecialidadController::class, 'edit'])->name('admin.especialidades.edit');
    Route::put('/admin/especialidades/{id}', [EspecialidadController::class, 'update'])->name('admin.especialidades.update');
    Route::post('/admin/especialidades/asignar', [EspecialidadController::class, 'asignar'])->name('admin.especialidades.asignar');
    Route::post('/admin/especialidades', [EspecialidadController::class, 'store'])->name('admin.especialidades.store');

    Route::get('/admin/servicios', [ServicioController::class, 'index'])->name('admin.servicios.index');
    Route::post('/admin/servicios', [ServicioController::class, 'store'])->name('admin.servicios.store');
});


Route::middleware(['auth', 'recepcionista'])->group(function () {
    Route::get('recepcionista/dashboard', [RecepcionistaController::class, 'dashboard'])->name('recepcionista.dashboard');
});

require __DIR__.'/auth.php';