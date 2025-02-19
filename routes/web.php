<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name("home");
Route::view('/sobre', 'about')->name("about");
Route::view('/contato', 'contact')->name("contact");

Route::get('/login', [AuthController::class, "login"])->name("login");
Route::post('/login', [AuthController::class, "loginPost"])->name("login.post");
Route::post('/logout', [AuthController::class, "logout"])->name("logout");

Route::get('/cadastro', [AuthController::class, "register"])->name("register");
Route::post('/cadastro', [AuthController::class, "registerPost"])->name("register.post");

Route::get('/perfil', [ProfileController::class, "update"])->middleware(['auth'])->name('profile');
Route::post('/perfil', [ProfileController::class, "updatePost"])->middleware(['auth'])->name('profile.update');

Route::get('/estoque', [StockController::class, 'listProducts'])->middleware(['auth'])->name('stock');
Route::get('/estoque/produto/{id}', [StockController::class, "infoProduct"])->middleware(['auth'])->name('stock.get');
Route::get('/estoque/detalhes/{id}', [StockController::class, "detailsProduct"])->middleware(['auth'])->name('stock.details');
Route::post('/estoque/novo', [StockController::class, "newProduct"])->middleware(['auth'])->name('stock.new');
Route::put('/estoque/compra', [StockController::class, "buyProduct"])->middleware(['auth'])->name('stock.buy');
Route::put('/estoque/venda', [StockController::class, "sellProduct"])->middleware(['auth'])->name('stock.sell');
Route::put('/estoque/editar/{id}', [StockController::class, "editProduct"])->middleware(['auth'])->name('stock.edit');
Route::delete('/estoque/deletar', [StockController::class, "deleteProduct"])->middleware(['auth'])->name('stock.delete');

Route::get('/painel', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/painel/transacoes', [DashboardController::class, 'getTransactions'])->middleware(['auth'])->name('dashboard.transactions');

Route::get('/opcoes', function () { return view('options'); })->middleware(['auth'])->name('options');

Route::get('/transacoes', function () { return view('transactions'); })->middleware(['auth'])->name('transactions');
Route::get('/transacoes/compras', [TransactionController::class, "getBuys"])->middleware(['auth'])->name('transactions.buys');
Route::get('/transacoes/vendas', [TransactionController::class, "getSells"])->middleware(['auth'])->name('transactions.sells');