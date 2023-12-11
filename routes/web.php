<?php

use App\Http\Controllers\ChaveController;
use App\Http\Controllers\ControleDeAcessoController;
use App\Http\Controllers\EncaixeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('painel');
});

Route::get('/painel', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('painel');   

Route::get('/users', [UserController::class, 'index'])->middleware(['auth', 'verified','permission:users'])->name('users');
Route::get('/users/{id}', [UserController::class, 'show'])->middleware(['auth', 'verified','permission:users'])->name('users.show');
Route::put('/users/{user}', [UserController::class, 'update'])->middleware(['auth', 'verified','permission:users'])->name('users.update');
Route::get('/indexForSolicitacoes', [UserController::class, 'indexForSolicitacoes'])->middleware(['auth', 'verified','permission:users'])->name('indexForSolicitacoes');
Route::get('/users/controleDeAcesso/{id}', [ControleDeAcessoController::class, 'show'])->middleware(['auth', 'verified','permission:users'])->name('controleDeAcessosUsers.show');
Route::post('/users/restaurarAcesso', [UserController::class, 'restaurarAcesso'])->middleware(['auth', 'verified','permission:users'])->name('controleDeAcessosUsers.restaurarAcesso');



Route::get('/encaixe', [EncaixeController::class, 'index'])->middleware(['auth', 'verified','permission:encaixeVisualizar'])->name('encaixe');
Route::get('/encaixes/{id}', [EncaixeController::class, 'show'])->middleware(['auth', 'verified','permission:encaixeVisualizar'])->name('encaixe.show');
Route::delete('/encaixe/{id}', [EncaixeController::class, 'delete'])->middleware(['auth', 'verified','permission:encaixe'])->name('encaixe.delete');
Route::put('/encaixes/{id}', [EncaixeController::class, 'updateMovimento'])->middleware(['auth', 'verified','permission:encaixe'])->name('encaixe.update');
Route::post('/encaixe', [EncaixeController::class, 'addEncaixe'])->middleware(['auth', 'verified','permission:encaixe'])->name('encaixe.add');
Route::post('/encaixeMovimento', [EncaixeController::class, 'addMovimento'])->middleware(['auth', 'verified','permission:encaixe'])->name('encaixeMovimento.add');
Route::delete('/encaixeMovimento/{id}', [EncaixeController::class, 'deletarMovimento'])->middleware(['auth', 'verified','permission:encaixe'])->name('encaixeMovimento.delete');
Route::delete('/encaixeConsumo/{id}', [EncaixeController::class, 'deletarConsumo'])->middleware(['auth', 'verified','permission:encaixe'])->name('encaixeConsumo.delete');
Route::get('/encaixe/getNomeMovimentos/{nome}', [EncaixeController::class, 'getNomeMovimentos'])->middleware(['auth', 'verified','permission:encaixe'])->name('encaixe.getmovimentos');
Route::get('/encaixe/getMovimentoTecidos/{tecido}', [EncaixeController::class, 'getMovimentoTecidos'])->middleware(['auth', 'verified','permission:encaixe'])->name('encaixe.getMovimentoTecidos');

Route::get('/controleDeAcesso', [ControleDeAcessoController::class, 'index'])->middleware(['auth', 'verified','permission:controleDeAcessos'])->name('controleDeAcessos');
Route::post('/controleDeAcesso/add', [ControleDeAcessoController::class, 'add'])->middleware(['auth', 'verified','permission:controleDeAcessos'])->name('controleDeAcessos.add');
Route::get('/controleDeAcesso/{id}', [ControleDeAcessoController::class, 'show'])->middleware(['auth', 'verified','permission:controleDeAcessos'])->name('controleDeAcessos.show');
Route::put('/controleDeAcesso/{id}', [ControleDeAcessoController::class, 'update'])->middleware(['auth', 'verified','permission:controleDeAcessos'])->name('controleDeAcessos.update');
Route::put('/controleDeAcesso/reg/{id}', [ControleDeAcessoController::class, 'updateReg'])->middleware(['auth', 'verified','permission:controleDeAcessos'])->name('controleDeAcessos.updateReg');
Route::delete('/controleDeAcesso/{id}', [ControleDeAcessoController::class, 'delete'])->middleware(['auth', 'verified','permission:controleDeAcessos'])->name('controleDeAcessos.delete');
Route::get('/controleDeAcesso/getNomeAcessos/{nome}', [ControleDeAcessoController::class, 'getAcessosPeloNome'])->middleware(['auth', 'verified','permission:controleDeAcessos'])->name('controleDeAcessos.getNomes');
Route::get('/controleDeAcesso/getEmpresasAcessos/{empresa}', [ControleDeAcessoController::class, 'getAcessosPelaEmpresa'])->middleware(['auth', 'verified','permission:controleDeAcessos'])->name('controleDeAcessos.getEmpresas');
Route::get('/controleDeAcesso/getSetoresAcessos/{setor}/{empresa}', [ControleDeAcessoController::class, 'getAcessosPeloSetor'])->middleware(['auth', 'verified','permission:controleDeAcessos'])->name('controleDeAcessos.getSetores');
Route::get('/controleDeAcesso/getPessoasAcessos/{pessoa}/{setor}', [ControleDeAcessoController::class, 'getAcessosPelaPessoa'])->middleware(['auth', 'verified','permission:controleDeAcessos'])->name('controleDeAcessos.getPessoas');
Route::post('/controleDeAcesso/solicitarDeletagem', [ControleDeAcessoController::class, 'solicitarDeletagem'])->middleware(['auth', 'verified','permission:controleDeAcessos'])->name('controleDeAcessos.solicitarDeletagem');

Route::get('/chaves', [ChaveController::class, 'index'])->middleware(['auth', 'verified','permission:chaves'])->name('chaves');
Route::post('/chaves/add', [ChaveController::class, 'add'])->middleware(['auth', 'verified','permission:chaves'])->name('chaves.add');
Route::put('/chaves/reg/{id}', [ChaveController::class, 'regSaida'])->middleware(['auth', 'verified','permission:chaves'])->name('chaves.reg');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
