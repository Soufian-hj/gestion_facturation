@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-8 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4v11H3zM17 3h4v18h-4zM10 14h4v7h-4z" /></svg>
        Tableau de bord
    </h1>

    <!-- Alertes importantes -->
    @if(count($alertes) > 0)
    <div class="mb-8 space-y-3">
        @foreach($alertes as $alerte)
        <div class="bg-white rounded-xl shadow p-4 border-l-4 border-{{ $alerte['type'] == 'warning' ? 'red' : 'blue' }}-500">
            <div class="flex items-center gap-3">
                <span class="text-2xl">{{ $alerte['icon'] }}</span>
                <div class="flex-1">
                    <p class="text-gray-700 font-medium">{{ $alerte['message'] }}</p>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Métriques principales -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
            <div class="text-4xl font-bold text-blue-600">{{ $clients }}</div>
            <div class="text-gray-600 mt-2">Clients</div>
        </div>
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
            <div class="text-4xl font-bold text-green-600">{{ $produits }}</div>
            <div class="text-gray-600 mt-2">Produits</div>
        </div>
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
            <div class="text-4xl font-bold text-purple-600">{{ $factures }}</div>
            <div class="text-gray-600 mt-2">Factures</div>
        </div>
        <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
            <div class="text-4xl font-bold text-orange-600">{{ number_format($chiffreAffaire, 2) }} DH</div>
            <div class="text-gray-600 mt-2">Chiffre d'affaires</div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4 text-gray-700 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            Actions rapides
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('factures.create') }}" class="bg-blue-50 hover:bg-blue-100 p-4 rounded-lg text-center transition-colors">
                <div class="text-blue-600 text-2xl mb-2">📄</div>
                <div class="font-medium text-gray-700">Nouvelle facture</div>
            </a>
            <a href="{{ route('devis.create') }}" class="bg-green-50 hover:bg-green-100 p-4 rounded-lg text-center transition-colors">
                <div class="text-green-600 text-2xl mb-2">📋</div>
                <div class="font-medium text-gray-700">Nouveau devis</div>
            </a>
            <a href="{{ route('clients.create') }}" class="bg-purple-50 hover:bg-purple-100 p-4 rounded-lg text-center transition-colors">
                <div class="text-purple-600 text-2xl mb-2">👤</div>
                <div class="font-medium text-gray-700">Nouveau client</div>
            </a>
            <a href="{{ route('produits.create') }}" class="bg-orange-50 hover:bg-orange-100 p-4 rounded-lg text-center transition-colors">
                <div class="text-orange-600 text-2xl mb-2">📦</div>
                <div class="font-medium text-gray-700">Nouveau produit</div>
            </a>
        </div>
    </div>

    <!-- Métriques avancées -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Performance du mois</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">CA du mois</span>
                    <span class="font-bold text-green-600">{{ number_format($caMois, 2) }} DH</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Évolution</span>
                    <span class="font-bold {{ $evolutionCA >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $evolutionCA >= 0 ? '+' : '' }}{{ number_format($evolutionCA, 1) }}%
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Devis acceptés</span>
                    <span class="font-bold text-blue-600">{{ $devisAcceptes }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">BL livrés</span>
                    <span class="font-bold text-purple-600">{{ $blLivre }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">En attente</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Devis en attente</span>
                    <span class="font-bold text-orange-600">{{ $devisEnAttente }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">BL en préparation</span>
                    <span class="font-bold text-yellow-600">{{ $blEnPreparation }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Factures impayées</span>
                    <span class="font-bold text-red-600">{{ $facturesImpayees }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Montant impayé</span>
                    <span class="font-bold text-red-600">{{ number_format($montantImpaye, 2) }} DH</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Statistiques récentes</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Nouveaux clients</span>
                    <span class="font-bold text-cyan-600">{{ $clientsRecent }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Produit le plus vendu</span>
                    <span class="font-bold text-pink-600">{{ $topProduitName }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Meilleur client</span>
                    <span class="font-bold text-indigo-600">{{ $bestClientName }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Taux de paiement</span>
                    <span class="font-bold text-green-600">{{ $factures > 0 ? round(($facturesPayees / $factures) * 100, 1) : 0 }}%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques et analyses -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Graphique des factures -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Répartition des factures</h3>
            <div class="flex-1 flex items-center justify-center">
                <canvas id="facturesChart" height="200"></canvas>
            </div>
        </div>

        <!-- Graphique d'évolution -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Évolution du CA ({{ now()->year }})</h3>
            <div class="flex-1 flex items-center justify-center">
                <canvas id="evolutionChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Top produits et clients -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Top produits -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Top 5 des produits</h3>
            <div class="space-y-3">
                @foreach($topProduits as $index => $produit)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <div class="font-medium text-gray-700">{{ $produit['nom'] }}</div>
                            <div class="text-sm text-gray-500">{{ $produit['quantite'] }} unités vendues</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-green-600">{{ number_format($produit['ca'], 2) }} DH</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top clients -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Top 5 des clients</h3>
            <div class="space-y-3">
                @foreach($topClients as $index => $client)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-bold text-sm">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <div class="font-medium text-gray-700">{{ $client['nom'] }}</div>
                            <div class="text-sm text-gray-500">{{ $client['nb_factures'] }} facture(s)</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-green-600">{{ number_format($client['ca'], 2) }} DH</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Activité récente -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-700">Activité récente (7 derniers jours)</h3>
        <div class="space-y-3">
            @forelse($facturesRecentes as $facture)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-700">Facture #{{ $facture->id }}</div>
                        <div class="text-sm text-gray-500">{{ $facture->client->nom }} - {{ $facture->date }}</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="font-bold text-green-600">{{ number_format($facture->total, 2) }} DH</div>
                    <div class="text-sm text-gray-500">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($facture->statut_paiement == 'payé') bg-green-100 text-green-800
                            @elseif($facture->statut_paiement == 'en attente') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $facture->statut_paiement }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p>Aucune facture récente</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique des factures
    const ctx1 = document.getElementById('facturesChart').getContext('2d');
    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Payées', 'En attente', 'Impayées'],
            datasets: [{
                data: [{{ $facturesPayees }}, {{ $facturesEnAttente }}, {{ $facturesImpayees }}],
                backgroundColor: ['#22c55e', '#eab308', '#ef4444'],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Graphique d'évolution du CA
    const ctx2 = document.getElementById('evolutionChart').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: @json($donneesGraphiques['labels']),
            datasets: [{
                label: 'Chiffre d\'affaires (DH)',
                data: @json($donneesGraphiques['ca']),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' DH';
                        }
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endsection
