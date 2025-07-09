<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Client;
use App\Models\LigneFacture;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Produit;


class FactureController extends Controller
{
    public function index()
    {
        $factures = Facture::with('client')->get();
        return view('factures.index', compact('factures'));
    }

   public function create()
   {
        $clients = Client::all(); // Liste des clients
        $produits = Produit::all(); // Liste des produits
        return view('factures.create', compact('clients', 'produits'));
   }

    public function store(Request $request)
    {
        // Créer la facture
        $facture = Facture::create($request->all());
        
        // Sauvegarder les lignes de facture
        if ($request->has('lignes')) {
            foreach ($request->lignes as $ligneData) {
                if (!empty($ligneData['produit_id']) && !empty($ligneData['quantite'])) {
                    $produit = Produit::find($ligneData['produit_id']);
                    $prixTotal = $produit->prix_unitaire * $ligneData['quantite'];
                    
                    LigneFacture::create([
                        'facture_id' => $facture->id,
                        'produit_id' => $ligneData['produit_id'],
                        'quantite' => $ligneData['quantite'],
                        'prix_total' => $prixTotal
                    ]);
                }
            }
        }
        
        return redirect()->route('factures.index')->with('success', 'Facture ajoutée avec succès.');
    }

    public function edit(Facture $facture)
    {
        $clients = Client::all();
        $produits = Produit::all();
        return view('factures.edit', compact('facture', 'clients', 'produits'));
    }

    public function update(Request $request, Facture $facture)
    {
        $facture->update($request->all());
        
        // Supprimer les anciennes lignes
        $facture->lignes()->delete();
        
        // Sauvegarder les nouvelles lignes de facture
        if ($request->has('lignes')) {
            foreach ($request->lignes as $ligneData) {
                if (!empty($ligneData['produit_id']) && !empty($ligneData['quantite'])) {
                    $produit = Produit::find($ligneData['produit_id']);
                    $prixTotal = $produit->prix_unitaire * $ligneData['quantite'];
                    
                    LigneFacture::create([
                        'facture_id' => $facture->id,
                        'produit_id' => $ligneData['produit_id'],
                        'quantite' => $ligneData['quantite'],
                        'prix_total' => $prixTotal
                    ]);
                }
            }
        }
        
        return redirect()->route('factures.index')->with('success', 'Facture modifiée avec succès.');
    }

    public function destroy(Facture $facture)
    {
        $facture->delete();
        return redirect()->route('factures.index')->with('success', 'Facture supprimée.');
    }
    public function downloadPDF(Facture $facture)
    {
        $facture->load('client', 'lignes.produit');

        $pdf = Pdf::loadView('factures.pdf', compact('facture'));

        return $pdf->download("facture_{$facture->id}.pdf");
    }
    public function show(Facture $facture)
    {
        $facture->load('client', 'lignes.produit');
        return view('factures.show', compact('facture'));
    }
}