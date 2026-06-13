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


Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/turnos', function () {
    return view('turnos');
})->name('turnos');
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

Route::get('recepcionista/dashboard', function(){
    return view('recepcionista.dashboard');
})->middleware(['auth'])->name('recepcionista.dashboard');

Route::resource('profesionales', ProfesionalController::class)
    ->middleware(['auth']);
Route::resource('recepcionistas', RecepcionistaController::class)
    ->middleware(['auth']);

ROute::get('/perfil', function() {
    $turnos = \App\Models\turno::where('user_id', auth()->id())
                ->orderBy('fecha', 'asc')
                ->orderBy('hora', 'asc')
                ->get();
    $proximos = $turnos ->where('fecha', '>=', now()->format('Y-m-d'));
    $historial = $turnos ->where('fecha', '<', now()->format('Y-m-d'));

    return view('cliente.perfil', compact('proximos','historial'));
})->middleware('auth')->name('cliente.perfil');

Route::post('/turnos', [TurnoController::class, 'store'])->middleware('auth')->name('turnos.store');


require __DIR__.'/auth.php';
