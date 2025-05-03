<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProtectedDownloads;
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
Route::middleware('guest.custom')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/createAccount', [HomeController::class, 'create'])->name('account.create');
    Route::post('/createAccount', [HomeController::class, 'store'])->name('account.store');
    Route::post('/login', [HomeController::class, 'login'])->name('login');
});

Route::middleware('logged.custom')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/perfil', [DashboardController::class, 'perfil'])->name('perfil');
    Route::post('/perfil', [DashboardController::class, 'update'])->name('perfil.update');
    
    Route::get('/product/list', [ProductController::class, 'index'])->name('product.list');
    Route::post('/product/list', [ProductController::class, 'index'])->name('productP.list');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update', [ProductController::class, 'update'])->name('product.update');
    Route::post('/product/delete', [ProductController::class, 'delete'])->name('product.delete');

    Route::get('/categorie/list', [CategorieController::class, 'index'])->name('categorie.list');
    Route::post('/categorie/list', [CategorieController::class, 'index'])->name('categorieP.list');
    Route::get('/categorie/create', [CategorieController::class, 'create'])->name('categorie.create');
    Route::post('/categorie/store', [CategorieController::class, 'store'])->name('categorie.store');
    Route::get('/categorie/edit/{id}', [CategorieController::class, 'edit'])->name('categorie.edit');
    Route::post('/categorie/update', [CategorieController::class, 'update'])->name('categorie.update');
    Route::post('/categorie/delete', [CategorieController::class, 'delete'])->name('categorie.delete');

    Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');

    Route::get('/visualizar-files/{path}', [ProtectedDownloads::class, 'visualizar'])->name('visualizar.files');
});
