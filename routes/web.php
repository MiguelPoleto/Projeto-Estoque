<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
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

Route::get('/perfil', [ProfileController::class, "update"])->middleware(['auth'])->name('profile');
Route::post('/perfil', [ProfileController::class, "updatePost"])->middleware(['auth'])->name('profile.update');

Route::get('/estoque', [StockController::class, 'listProducts'])->middleware(['auth'])->name('stock');
Route::post('/estoque', [StockController::class, "newProduct"])->middleware(['auth'])->name('stock.new');
Route::delete('/estoque', [StockController::class, "deleteProduct"])->middleware(['auth'])->name('stock.delete');

Route::get('/painel', function () { return view('dashboard'); })->middleware(['auth'])->name('dashboard');
Route::get('/vendas', function () { return view('sales'); })->middleware(['auth'])->name('sales');