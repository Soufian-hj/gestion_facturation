<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devis;
use App\Models\Client;
use App\Models\Produit;
use App\Models\Facture;
use App\Models\Ligne;
use App\Models\LigneFacture;
use Barryvdh\DomPDF\Facade\Pdf;

class DevisController extends Controller
{
    public function index()
    {
        $devis = Devis::with('client')->get();
        return view('devis.index', compact('devis'));
    }

    public function create()
    {
        $clients = Client::all();
        $produits = Produit::all();
        return view('devis.create', compact('clients', 'produits'));
    }

    public function store(Request $request)
    {
        $devis = Devis::create([
            'client_id' => $request->client_id,
            'date' => $request->date,
            'etat' => $request->etat,
        ]);
        if ($request->has('lignes')) {
            foreach ($request->lignes as $ligneData) {
                if (!empty($ligneData['produit_id']) && !empty($ligneData['quantite']) && !empty($ligneData['prix_unitaire'])) {
                    Ligne::create([
                        'devis_id' => $devis->id,
                        'produit_id' => $ligneData['produit_id'],
                        'quantite' => $ligneData['quantite'],
                        'prix_unitaire' => $ligneData['prix_unitaire'],
                    ]);
                }
            }
        }
        return redirect()->route('devis.index')->with('success', 'Devis ajouté avec succès.');
    }

    public function show(Devis $devis)
    {
        $devis->load('client', 'lignes.produit');
        return view('devis.show', compact('devis'));
    }

    public function edit(Devis $devis)
    {
        // Debug: vérifier que le devis est bien récupéré
        if (!$devis) {
            abort(404, 'Devis non trouvé');
        }
        
        $clients = Client::all();
        $produits = Produit::all();
        $devis->load('lignes');
        return view('devis.edit', ['devis' => $devis, 'clients' => $clients, 'produits' => $produits]);
    }

    public function update(Request $request, Devis $devis)
    {
        $devis->update([
            'client_id' => $request->client_id,
            'date' => $request->date,
            'etat' => $request->etat,
        ]);
        $devis->lignes()->delete();
        if ($request->has('lignes')) {
            foreach ($request->lignes as $ligneData) {
                if (!empty($ligneData['produit_id']) && !empty($ligneData['quantite']) && !empty($ligneData['prix_unitaire'])) {
                    Ligne::create([
                        'devis_id' => $devis->id,
                        'produit_id' => $ligneData['produit_id'],
                        'quantite' => $ligneData['quantite'],
                        'prix_unitaire' => $ligneData['prix_unitaire'],
                    ]);
                }
            }
        }
        return redirect()->route('devis.index')->with('success', 'Devis modifié avec succès.');
    }

    public function destroy(Devis $devis)
    {
        try {
        $devis->delete();
        return redirect()->route('devis.index')->with('success', 'Devis supprimé.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('devis.index')->with('error', 'Impossible de supprimer ce devis car il est utilisé dans un bon de livraison.');
        }
    }

    public function accepter($id)
    {
        $devis = Devis::with('lignes')->findOrFail($id);
        $facture = Facture::create([
            'client_id' => $devis->client_id,
            'date' => now(),
            'total' => 0,
            'statut_paiement' => 'en attente',
        ]);
        $total = 0;
        foreach ($devis->lignes as $ligne) {
            $prixTotal = $ligne->quantite * $ligne->prix_unitaire;
            LigneFacture::create([
                'facture_id' => $facture->id,
                'produit_id' => $ligne->produit_id,
                'quantite' => $ligne->quantite,
                'prix_total' => $prixTotal,
            ]);
            $total += $prixTotal;
        }
        $facture->total = $total;
        $facture->save();
        return redirect()->route('factures.show', $facture)->with('success', 'Facture créée à partir du devis.');
    }

    public function downloadPDF(Devis $devis)
    {
        $devis->load('client', 'lignes.produit');
        $pdf = Pdf::loadView('devis.pdf', compact('devis'));
        return $pdf->download("devis_{$devis->id}.pdf");
    }
}
