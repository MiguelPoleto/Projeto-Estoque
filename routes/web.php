<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name("home");
Route::view('/sobre', 'about')->name("about");
Route::view('/contato', 'contact')->name("contact");
Route::view('/opcoes', 'options')->name("options");

Route::get('/login', [AuthController::class, "login"])->name("login");
Route::post('/login', [AuthController::class, "loginPost"])->name("login.post");
Route::post('/logout', [AuthController::class, "logout"])->name("logout");

Route::get('/cadastro', [AuthController::class, "register"])->name("register");
Route::post('/cadastro', [AuthController::class, "registerPost"])->name("register.post");

Route::get('/perfil', function () { return view('profile'); })->middleware(['auth'])->name('profile');
// Route::get('/painel', function () { return view('dashboard'); })->middleware(['auth'])->name('dashboard');


Route::get('/painel', function () { return view('dashboard'); })->middleware(['auth'])->name('dashboard');
Route::get('/estoque', function () { return view('stock'); })->middleware(['auth'])->name('stock');
Route::get('/vendas', function () { return view('sales'); })->middleware(['auth'])->name('sales');