<?php

namespace App\Http\Controllers;

use App\Models\BonLivraison;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BonLivraisonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bonLivraisons = \App\Models\BonLivraison::with('client', 'devi')->get();
        return view('bon_livraisons.index', compact('bonLivraisons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $devis = \App\Models\Devis::all();
        $clients = \App\Models\Client::all();
        return view('bon_livraisons.create', compact('devis', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'numeroBL' => 'required|unique:bon_livraisons,numeroBL',
            'date' => 'required|date',
            'devi_id' => 'required|exists:devis,id',
            'client_id' => 'required|exists:clients,id',
            'statut' => 'nullable|string'
        ]);
        \App\Models\BonLivraison::create($validated);
        return redirect()->route('bon_livraisons.index')->with('success', 'Bon de livraison créé !');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\BonLivraison $bonLivraison)
    {
        $bonLivraison->load('client', 'devi', 'lignes');
        return view('bon_livraisons.show', compact('bonLivraison'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\BonLivraison $bonLivraison)
    {
        $devis = \App\Models\Devis::all();
        $clients = \App\Models\Client::all();
        return view('bon_livraisons.edit', compact('bonLivraison', 'devis', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\BonLivraison $bonLivraison)
    {
        $validated = $request->validate([
            'numeroBL' => 'required|unique:bon_livraisons,numeroBL,' . $bonLivraison->idBL . ',idBL',
            'date' => 'required|date',
            'devi_id' => 'required|exists:devis,id',
            'client_id' => 'required|exists:clients,id',
            'statut' => 'nullable|string'
        ]);
        $bonLivraison->update($validated);
        return redirect()->route('bon_livraisons.index')->with('success', 'Bon de livraison modifié !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\BonLivraison $bonLivraison)
    {
        $bonLivraison->delete();
        return redirect()->route('bon_livraisons.index')->with('success', 'Bon de livraison supprimé !');
    }

    public function downloadPDF(BonLivraison $bonLivraison)
    {
        $bonLivraison->load('client', 'devi');
        $pdf = Pdf::loadView('bon_livraisons.pdf', compact('bonLivraison'));
        return $pdf->download("bon_livraison_{$bonLivraison->idBL}.pdf");
    }
}
