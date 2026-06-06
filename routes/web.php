<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\ProfesionalController;
use App\Http\Controllers\RecepcionistaController;
use App\Models\Profesional;
use App\Models\Recepcionista;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/turnos', function () {
    return view('turnos');
})->name('turnos');

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

require __DIR__.'/auth.php';
