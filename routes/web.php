<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LigneFactureController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('clients', ClientController::class);
Route::resource('produits', ProduitController::class);
Route::resource('factures', FactureController::class);
Route::resource('ligne_factures', LigneFactureController::class);
Route::get('/factures/{facture}/download', [FactureController::class, 'downloadPDF'])->name('factures.download');