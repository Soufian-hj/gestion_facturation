@extends('layouts.app')

@section('title', 'Liste des Bons de Livraison')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <h1 class="text-3xl font-extrabold tracking-tight text-gray-800 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2v-6a2 2 0 00-2-2h-2a2 2 0 00-2 2v6a2 2 0 002 2z" /></svg>
        Bons de Livraison
    </h1>
    <a href="{{ route('bon_livraisons.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-700 text-white px-6 py-2 rounded-lg shadow hover:from-blue-600 hover:to-blue-800 font-semibold transition">+ Nouveau BL</a>
</div>
@if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-6 border-l-4 border-green-500 shadow">
        {{ session('success') }}
    </div>
@endif
<div class="overflow-x-auto">
<table class="min-w-full bg-white rounded-xl shadow-lg border border-gray-200">
    <thead class="bg-gradient-to-r from-gray-100 to-gray-200">
        <tr>
            <th class="p-3 text-left font-semibold text-gray-700">Numéro BL</th>
            <th class="p-3 text-left font-semibold text-gray-700">Date</th>
            <th class="p-3 text-left font-semibold text-gray-700">Client</th>
            <th class="p-3 text-left font-semibold text-gray-700">Devis</th>
            <th class="p-3 text-left font-semibold text-gray-700">Statut</th>
            <th class="p-3 text-center font-semibold text-gray-700">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($bonLivraisons as $bl)
        <tr class="border-t border-gray-100 hover:bg-blue-50 transition">
            <td class="p-3">
                <span class="font-mono text-blue-600 font-bold bg-blue-50 px-2 py-1 rounded">{{ $bl->numeroBL }}</span>
            </td>
            <td class="p-3 text-gray-600">{{ \Carbon\Carbon::parse($bl->date)->format('d/m/Y') }}</td>
            <td class="p-3 text-gray-800 font-medium">{{ $bl->client->nom ?? '-' }}</td>
            <td class="p-3 text-gray-800">
                <span class="bg-gray-100 px-2 py-1 rounded text-sm">Devis #{{ $bl->devi->id ?? '-' }}</span>
            </td>
            <td class="p-3">
                @switch($bl->statut)
                    @case('en_preparation')
                        <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-300">
                            📦 En préparation
                        </span>
                        @break
                    @case('pret')
                        <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-700 border border-blue-300">
                            ✅ Prêt
                        </span>
                        @break
                    @case('livre')
                        <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-300">
                            🚚 Livré
                        </span>
                        @break
                    @case('annule')
                        <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700 border border-red-300">
                            ❌ Annulé
                        </span>
                        @break
                    @default
                        <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-700 border border-gray-300">
                            {{ ucfirst($bl->statut) }}
                        </span>
                @endswitch
            </td>
            <td class="p-3 text-center">
                <div class="flex flex-col md:flex-row gap-2 justify-center items-center">
                    <a href="{{ route('bon_livraisons.show', $bl->idBL) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200 font-medium transition" title="Voir">
                        👁️ Voir
                    </a>
                    <a href="{{ route('bon_livraisons.edit', $bl->idBL) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200 font-medium transition" title="Modifier">
                        ✏️ Modifier
                    </a>
                    <a href="{{ route('bon_livraisons.downloadPDF', $bl->idBL) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium shadow transition" title="Télécharger PDF">
                        📄 PDF
                    </a>
                    <form method="POST" action="{{ route('bon_livraisons.destroy', $bl->idBL) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bon de livraison ?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 font-medium transition" title="Supprimer">
                            🗑️ Supprimer
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="p-8 text-center text-gray-500">
                <div class="flex flex-col items-center gap-2">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2v-6a2 2 0 00-2-2h-2a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-lg font-medium">Aucun bon de livraison trouvé</p>
                    <p class="text-sm">Commencez par créer votre premier bon de livraison</p>
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection 