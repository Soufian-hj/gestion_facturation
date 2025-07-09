<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Produit;
use App\Models\Facture;
use App\Models\Devis;
use App\Models\BonLivraison;
use Carbon\Carbon;

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

        // === NOUVELLES MÉTRIQUES CRÉATIVES ===
        
        // Chiffre d'affaires du mois en cours
        $caMois = Facture::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('total');
        
        // Chiffre d'affaires du mois précédent
        $caMoisPrecedent = Facture::whereMonth('date', now()->subMonth()->month)
            ->whereYear('date', now()->subMonth()->year)
            ->sum('total');
        
        // Évolution du CA (pourcentage)
        $evolutionCA = $caMoisPrecedent > 0 ? (($caMois - $caMoisPrecedent) / $caMoisPrecedent) * 100 : 0;
        
        // Devis en attente
        $devisEnAttente = Devis::where('etat', 'en_attente')->count();
        
        // Devis acceptés ce mois
        $devisAcceptes = Devis::where('etat', 'accepté')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();
        
        // Bons de livraison en préparation
        $blEnPreparation = BonLivraison::where('statut', 'en_preparation')->count();
        
        // Bons de livraison livrés ce mois
        $blLivre = BonLivraison::where('statut', 'livré')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();
        
        // Factures impayées (montant total)
        $montantImpaye = Facture::where('statut_paiement', 'impayée')->sum('total');
        
        // Top 5 des produits les plus vendus
        $topProduits = \App\Models\LigneFacture::select('produit_id')
            ->selectRaw('SUM(quantite) as total_qte, SUM(prix_total) as total_ca')
            ->groupBy('produit_id')
            ->orderByDesc('total_qte')
            ->limit(5)
            ->get()
            ->map(function($item) {
                $produit = Produit::find($item->produit_id);
                return [
                    'nom' => $produit ? $produit->nom : 'Produit inconnu',
                    'quantite' => $item->total_qte,
                    'ca' => $item->total_ca
                ];
            });
        
        // Top 5 des clients par CA
        $topClients = Facture::select('client_id')
            ->selectRaw('SUM(total) as total_ca, COUNT(*) as nb_factures')
            ->groupBy('client_id')
            ->orderByDesc('total_ca')
            ->limit(5)
            ->get()
            ->map(function($item) {
                $client = Client::find($item->client_id);
                return [
                    'nom' => $client ? $client->nom : 'Client inconnu',
                    'ca' => $item->total_ca,
                    'nb_factures' => $item->nb_factures
                ];
            });
        
        // Factures récentes (7 derniers jours)
        $facturesRecentes = Facture::with('client')
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Alertes importantes
        $alertes = [];
        
        if ($facturesImpayees > 0) {
            $alertes[] = [
                'type' => 'warning',
                'message' => "{$facturesImpayees} facture(s) impayée(s) - Montant: " . number_format($montantImpaye, 2) . " DH",
                'icon' => '⚠️'
            ];
        }
        
        if ($devisEnAttente > 0) {
            $alertes[] = [
                'type' => 'info',
                'message' => "{$devisEnAttente} devis en attente de réponse",
                'icon' => '📋'
            ];
        }
        
        if ($blEnPreparation > 0) {
            $alertes[] = [
                'type' => 'info',
                'message' => "{$blEnPreparation} bon(s) de livraison en préparation",
                'icon' => '📦'
            ];
        }
        
        // Données pour graphiques
        $donneesGraphiques = [
            'labels' => ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            'ca' => [],
            'factures' => []
        ];
        
        for ($i = 1; $i <= 12; $i++) {
            $caMois = Facture::whereMonth('date', $i)
                ->whereYear('date', now()->year)
                ->sum('total');
            $donneesGraphiques['ca'][] = $caMois;
            
            $nbFactures = Facture::whereMonth('date', $i)
                ->whereYear('date', now()->year)
                ->count();
            $donneesGraphiques['factures'][] = $nbFactures;
        }

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
            'bestClientName',
            'caMois',
            'evolutionCA',
            'devisEnAttente',
            'devisAcceptes',
            'blEnPreparation',
            'blLivre',
            'montantImpaye',
            'topProduits',
            'topClients',
            'facturesRecentes',
            'alertes',
            'donneesGraphiques'
        ));
    }
}
