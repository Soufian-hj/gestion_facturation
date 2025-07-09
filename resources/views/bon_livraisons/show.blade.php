@extends('layouts.app')

@section('title', 'Détail du Bon de Livraison')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-200 mt-8">
    <h1 class="text-2xl font-bold mb-6 text-blue-700 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2v-6a2 2 0 00-2-2h-2a2 2 0 00-2 2v6a2 2 0 002 2z" /></svg>
        Détail du Bon de Livraison
    </h1>
    <ul class="mb-6 space-y-2">
        <li><span class="font-semibold text-gray-700">Numéro :</span> <span class="text-gray-900">{{ $bonLivraison->idBL }}</span></li>
        <li><span class="font-semibold text-gray-700">Date :</span> <span class="text-gray-900">{{ $bonLivraison->date }}</span></li>
        <li><span class="font-semibold text-gray-700">Client :</span> <span class="text-gray-900">{{ $bonLivraison->client->nom ?? '-' }}</span></li>
        <li><span class="font-semibold text-gray-700">Devis :</span> <span class="text-gray-900">{{ $bonLivraison->devi->id ?? '-' }}</span></li>
        <li><span class="font-semibold text-gray-700">Statut :</span>
            @if($bonLivraison->statut === 'en_preparation')
                <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-300">En préparation</span>
            @else
                <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-300">{{ ucfirst($bonLivraison->statut) }}</span>
            @endif
        </li>
    </ul>
    <div class="flex gap-2">
        <a href="{{ route('bon_livraisons.index') }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-700">Retour à la liste</a>
        <a href="{{ route('bon_livraisons.edit', $bonLivraison->idBL) }}" class="px-4 py-2 rounded bg-yellow-100 text-yellow-800 hover:bg-yellow-200 font-semibold">Modifier</a>
        <a href="{{ route('bon_livraisons.downloadPDF', $bonLivraison->idBL) }}" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 font-semibold">Télécharger PDF</a>
        <form action="{{ route('bon_livraisons.destroy', $bonLivraison->idBL) }}" method="POST" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded bg-red-100 text-red-700 hover:bg-red-200 font-semibold">Supprimer</button>
        </form>
    </div>
</div>
@endsection 