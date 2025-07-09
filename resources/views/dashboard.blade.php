@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-6xl mx-auto py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-8 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h4v11H3zM17 3h4v18h-4zM10 14h4v7h-4z" /></svg>
        Tableau de bord
    </h1>
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
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div>
            <div class="grid grid-cols-1 gap-6 mb-6">
                <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                    <div class="text-3xl font-bold text-cyan-600">{{ $clientsRecent }}</div>
                    <div class="text-gray-600 mt-2 text-center">Nouveaux clients ce mois</div>
                </div>
                <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                    <div class="text-3xl font-bold text-pink-600">{{ $topProduitName }}</div>
                    <div class="text-gray-600 mt-2 text-center">Produit le plus vendu</div>
                </div>
                <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                    <div class="text-3xl font-bold text-indigo-600">{{ $bestClientName }}</div>
                    <div class="text-gray-600 mt-2 text-center">Meilleur client (CA)</div>
                </div>
            </div>
        </div>
        <div>
            <div class="bg-white rounded-xl shadow p-6 h-full flex flex-col">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Statistiques récentes</h2>
                <ul class="list-disc pl-6 text-gray-700 mb-6">
                    <li><span class="font-semibold">Factures payées :</span> {{ $facturesPayees }}</li>
                    <li><span class="font-semibold">Factures en attente :</span> {{ $facturesEnAttente }}</li>
                    <li><span class="font-semibold">Factures annulées :</span> {{ $facturesImpayees }}</li>
                </ul>
                <div class="flex-1 flex items-center justify-center">
                    <canvas id="facturesChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('facturesChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Payées', 'En attente', 'Annulées'],
            datasets: [{
                data: [{{ $facturesPayees }}, {{ $facturesEnAttente }}, {{ $facturesImpayees }}],
                backgroundColor: ['#22c55e', '#eab308', '#ef4444'],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endsection
