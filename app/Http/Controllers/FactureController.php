<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Models\Client;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
    public function index()
    {
        $factures = Facture::with('client')->get();
        return view('factures.index', compact('factures'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('factures.create', compact('clients'));
    }

    public function store(Request $request)
    {
        Facture::create($request->all());
        return redirect()->route('factures.index')->with('success', 'Facture ajoutée avec succès.');
    }

    public function edit(Facture $facture)
    {
        $clients = Client::all();
        return view('factures.edit', compact('facture', 'clients'));
    }

    public function update(Request $request, Facture $facture)
    {
        $facture->update($request->all());
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
}
