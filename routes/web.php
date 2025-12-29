<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EtudiantController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Firebase Password Reset
    Route::get('/forgot-password', [App\Http\Controllers\FirebaseAuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\FirebaseAuthController::class, 'sendResetLinkEmail'])->name('password.email');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes pour les étudiants (admin seulement)
    Route::middleware('admin')->group(function () {
        Route::resource('etudiants', EtudiantController::class);
    });
    
    // Route pour voir son propre profil (étudiant)
    Route::get('/profil', function () {
        return view('etudiants.show', ['etudiant' => auth()->user()->etudiant]);
    })->name('profil');
});