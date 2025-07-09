<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LigneFactureController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\BonLivraisonController;




Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('clients', ClientController::class);
Route::resource('produits', ProduitController::class);
Route::resource('factures', FactureController::class);
Route::resource('ligne_factures', LigneFactureController::class);
Route::resource('bon_livraisons', BonLivraisonController::class);
Route::get('/factures/{facture}/download', [FactureController::class, 'downloadPDF'])->name('factures.download');
// Route::resource('devis', DevisController::class); // Commenté pour éviter les conflits
Route::get('/devis', [DevisController::class, 'index'])->name('devis.index');
Route::get('/devis/create', [DevisController::class, 'create'])->name('devis.create');
Route::post('/devis', [DevisController::class, 'store'])->name('devis.store');
Route::get('/devis/{devis}', [DevisController::class, 'show'])->name('devis.show');
Route::get('/devis/{devis}/edit', [DevisController::class, 'edit'])->name('devis.edit');
Route::put('/devis/{devis}', [DevisController::class, 'update'])->name('devis.update');
Route::delete('/devis/{devis}', [DevisController::class, 'destroy'])->name('devis.destroy');
Route::get('/devis/{devis}/download', [\App\Http\Controllers\DevisController::class, 'downloadPDF'])->name('devis.downloadPDF');
Route::post('devis/{devis}/accepter', [DevisController::class, 'accepter'])->name('devis.accepter');
Route::get('/bon_livraisons/{bonLivraison}/download', [App\Http\Controllers\BonLivraisonController::class, 'downloadPDF'])->name('bon_livraisons.downloadPDF');