<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Gestao\HomeGestaoController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Gestao\ServiceController;
use App\Http\Controllers\Gestao\CotacaoController;
use App\Http\Controllers\Relatorios\RelatorioPdfController;




Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home-gestor', [HomeGestaoController::class, 'index'])->name('home_gestor');

Route::get('/home-user', [HomeController::class, 'userHome'])->name('home_user');

Route::get('/admin/users', [UserController::class, 'create'])->name('admin.users.create');
Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
Route::get('/admin/users/list', [UserController::class, 'index'])->name('admin.users.index');
Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');


Route::get('/gestao/servicos/add', [ServiceController::class, 'create'])->name('gestao.servicos.add');
Route::post('/gestao/servicos/add', [ServiceController::class, 'store'])->name('gestao.servicos.store');
Route::get('/gestao/servicos/list', [ServiceController::class, 'showAll'])->name('gestao.servicos.showAll');
Route::get('/gestao/servicos/{id}/edit', [ServiceController::class, 'edit'])->name('gestao.servicos.edit');
Route::put('/gestao/servicos/{id}', [ServiceController::class, 'update'])->name('gestao.servicos.update');
Route::delete('/gestao/servicos/{id}', [ServiceController::class, 'destroy'])->name('gestao.servicos.destroy');

Route::get('/gestao/servicos/catalogo', [ServiceController::class, 'catalogo'])->name('gestao.servicos.catalogo');
Route::get('/gestao/servicos/cartao', [ServiceController::class, 'cartao'])->name('gestao.servicos.cartao');


// Rotas para Cotações

Route::get('/cotacoes/create', [App\Http\Controllers\Gestao\CotacaoController::class, 'create'])->name('gestao.cotacoes.create');
Route::post('/cotacoes/store', [App\Http\Controllers\Gestao\CotacaoController::class, 'store'])->name('gestao.cotacoes.store');

Route::post('/cotacao/pdf', [App\Http\Controllers\Gestao\CotacaoController::class, 'gerarPDF'])->name('cotacao.pdf');


Route::post('/cotacao/processar', [App\Http\Controllers\Gestao\CotacaoController::class, 'processar'])->name('cotacao.processar');  

Route::get('/cotacoes', [App\Http\Controllers\Gestao\CotacaoController::class, 'listar'])->name('gestao.cotacoes.listar');
Route::get('/cotacao/{id}', [App\Http\Controllers\Gestao\CotacaoController::class, 'visualizar'])->name('gestao.cotacoes.show');




// Route::prefix('cotacao')->group(function () {
//     Route::get('/proximo-numero', [App\Http\Controllers\Gestao\CotacaoController::class, 'getProximoNumero'])->name('cotacao.proximo-numero');
//     Route::get('/resetar-contador', [App\Http\Controllers\Gestao\CotacaoController::class, 'resetarContador'])->name('cotacao.resetar-contador');
//     Route::get('/numeros-gerados', [App\Http\Controllers\Gestao\CotacaoController::class, 'verNumerosGerados'])->name('cotacao.numeros-gerados');
//     // ... outras rotas
// });



// Rotas AJAX para o contador (DEVEM vir PRIMEIRO)
Route::prefix('cotacao')->group(function () {
    // Rotas ESPECÍFICAS (sem parâmetros) - Colocar PRIMEIRO
    Route::get('/proximo-numero', [CotacaoController::class, 'getProximoNumero'])->name('cotacao.proximo-numero');
    Route::get('/resetar-contador', [CotacaoController::class, 'resetarContador'])->name('cotacao.resetar-contador');
    Route::get('/numeros-gerados', [CotacaoController::class, 'verNumerosGerados'])->name('cotacao.numeros-gerados');
    Route::get('/create', [CotacaoController::class, 'create'])->name('cotacao.create');
    
    // Rotas POST
    Route::post('/processar', [CotacaoController::class, 'processar'])->name('cotacao.processar');
    Route::post('/pdf', [CotacaoController::class, 'gerarPDF'])->name('cotacao.pdf');
    Route::post('/enviar-email', [CotacaoController::class, 'enviarEmail'])->name('cotacao.enviar-email');
    
    // Rotas com parâmetros DINÂMICOS (DEVEM vir por ÚLTIMO)
    Route::get('/visualizar/{id}', [CotacaoController::class, 'visualizar'])->name('cotacao.visualizar');
    Route::get('/download-pdf/{id}', [CotacaoController::class, 'downloadPDF'])->name('cotacao.download-pdf');
    Route::delete('/{id}', [CotacaoController::class, 'destroy'])->name('cotacao.destroy');
});




// Route::put('/cotacao/{id}', [App\Http\Controllers\Gestao\CotacaoController::class, 'aprovar'])->name('cotacao.aprovar');
// Route::put('/cotacao/{id}/rejeitar', [App\Http\Controllers\Gestao\CotacaoController::class, 'rejeitar'])->name('cotacao.rejeitar');

Route::post('/cotacao/enviar-whatsapp', [CotacaoController::class, 'enviarWhatsApp'])->name('cotacao.enviar-whatsapp');
Route::post('/cotacao/enviar-email', [CotacaoController::class, 'enviarEmail'])->name('cotacao.enviar-email');


// Rotas para Faturas
Route::get('/gestao/facturas/create', [App\Http\Controllers\Gestao\FacturaController::class, 'create'])->name('gestao.facturas.create');
Route::get('/gestao/facturas/processar', [App\Http\Controllers\Gestao\FacturaController::class, 'processar'])->name('factura.processar');
Route::get('/gestao/facturas/gerar-pdf', [App\Http\Controllers\Gestao\FacturaController::class, 'gerarPDF'])->name('factura.pdf');
Route::post('/gestao/facturas/store', [App\Http\Controllers\Gestao\FacturaController::class, 'store'])->name('gestao.facturas.store');



Route::get('/gestao/cotacoes/{id}/pdf', [CotacaoController::class, 'downloadPDF'])
    ->name('gestao.cotacoes.pdf');
    

// Route::get('/relatorio-pdf', [RelatorioPdfController::class, 'gerar']);


Route::get('/cotacoes/gerar-pdf-tcpdf', [App\Http\Controllers\Gestao\CotacaoPDFController::class, 'gerarPDFTCPDF'])
    ->name('cotacoes.gerar-pdf-tcpdf');

// use App\Http\Controllers\CotacaoPDFController;

// // Rotas para PDF e envio
// Route::prefix('cotacao')->group(function () {
//     Route::post('/pdf', [CotacaoPDFController::class, 'gerarPDF'])->name('cotacao.pdf');
    // Route::post('/enviar-email', [CotacaoPDFController::class, 'enviarEmail'])->name('cotacao.enviar-email');
    // Route::post('/whatsapp-link', [CotacaoPDFController::class, 'gerarLinkWhatsApp'])->name('cotacao.whatsapp-link');
    // Route::get('/limpar-temporarios', [CotacaoPDFController::class, 'limparTemporarios'])->name('cotacao.limpar-temporarios');
// });

// Route::middleware('auth')->group(function () {
//     Route::get('/home', fn() => view('home'))->name('home');
//     Route::get('/home-gestor', fn() => view('home_gestor'))->name('home_gestor');
//     Route::get('/home-user', fn() => view('home_user'))->name('home_user');
// });
