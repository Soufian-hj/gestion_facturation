<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Produit;
use App\Models\Facture;

class DashboardController extends Controller
{
    public function index()
    {
        $clients = Client::count();
        $produits = Produit::count();
        $factures = Facture::count();
        $chiffreAffaire = Facture::sum('total');
        $facturesPayees = Facture::where('statut_paiement', 'payé')->count();
        $facturesEnAttente = Facture::where('statut_paiement', 'en attente')->count();
        $facturesImpayees = Facture::where('statut_paiement', 'impayée')->count();

        // Nouveaux clients ce mois
        $clientsRecent = Client::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();

        // Produit le plus vendu (par quantité totale)
        $topProduit = \App\Models\LigneFacture::select('produit_id')
            ->selectRaw('SUM(quantite) as total_qte')
            ->groupBy('produit_id')
            ->orderByDesc('total_qte')
            ->first();
        $topProduitName = $topProduit ? Produit::find($topProduit->produit_id)->nom : '-';

        // Meilleur client (par chiffre d'affaires)
        $bestClient = Facture::select('client_id')
            ->selectRaw('SUM(total) as ca')
            ->groupBy('client_id')
            ->orderByDesc('ca')
            ->first();
        $bestClientName = $bestClient ? Client::find($bestClient->client_id)->nom : '-';

        return view('dashboard', compact(
            'clients',
            'produits',
            'factures',
            'chiffreAffaire',
            'facturesPayees',
            'facturesEnAttente',
            'facturesImpayees',
            'clientsRecent',
            'topProduitName',
            'bestClientName'
        ));
    }
}
