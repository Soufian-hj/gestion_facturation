<?php

namespace App\Http\Controllers;

use App\Models\LigneFacture;
use App\Models\Facture;
use App\Models\Produit;
use Illuminate\Http\Request;

class LigneFactureController extends Controller
{
    public function index()
    {
        $lignes = LigneFacture::with(['facture', 'produit'])->get();
        return view('ligne_factures.index', compact('lignes'));
    }

    public function create()
    {
        $factures = \App\Models\Facture::all();
        $produits = \App\Models\Produit::all();
        return view('ligne_factures.create', compact('factures', 'produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'facture_id' => 'required|exists:factures,id',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $produit = Produit::findOrFail($request->produit_id);
        $prix_total = $produit->prix_unitaire * $request->quantite;

        LigneFacture::create([
            'facture_id' => $request->facture_id,
            'produit_id' => $request->produit_id,
            'quantite' => $request->quantite,
            'prix_total' => $prix_total,
        ]);

        return redirect()->route('ligne_factures.index')->with('success', 'Ligne ajoutée.');
    }

    public function edit(LigneFacture $ligne_facture)
    {
        $factures = \App\Models\Facture::all();
        $produits = \App\Models\Produit::all();
        return view('ligne_factures.edit', compact('ligne_facture', 'factures', 'produits'));
    }

    public function update(Request $request, LigneFacture $ligne_facture)
    {
        $request->validate([
            'facture_id' => 'required|exists:factures,id',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
        ]);

        $produit = Produit::findOrFail($request->produit_id);
        $prix_total = $produit->prix_unitaire * $request->quantite;

        $ligne_facture->update([
            'facture_id' => $request->facture_id,
            'produit_id' => $request->produit_id,
            'quantite' => $request->quantite,
            'prix_total' => $prix_total,
        ]);

        return redirect()->route('ligne_factures.index')->with('success', 'Ligne modifiée.');
    }

    public function destroy(LigneFacture $ligne_facture)
    {
        $ligne_facture->delete();
        return redirect()->route('ligne_factures.index')->with('success', 'Ligne supprimée.');
    }
}
