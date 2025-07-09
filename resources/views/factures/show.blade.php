@extends('layouts.app')

@section('title', 'Détail de la Facture')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-200 mt-8">
    <h1 class="text-2xl font-bold mb-6 text-blue-700 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2v-6a2 2 0 00-2-2h-2a2 2 0 00-2 2v6a2 2 0 002 2z" /></svg>
        Détail de la Facture
    </h1>
    <ul class="mb-6 space-y-2">
        <li><span class="font-semibold text-gray-700">Numéro :</span> <span class="text-gray-900">#{{ $facture->id }}</span></li>
        <li><span class="font-semibold text-gray-700">Date :</span> <span class="text-gray-900">{{ $facture->date }}</span></li>
        <li><span class="font-semibold text-gray-700">Client :</span> <span class="text-gray-900">{{ $facture->client->nom ?? '-' }}</span></li>
        <li><span class="font-semibold text-gray-700">Statut :</span>
            @if($facture->statut_paiement === 'payée')
                <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-300">Payée</span>
            @elseif($facture->statut_paiement === 'en attente')
                <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-300">En attente</span>
            @else
                <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700 border border-red-300">Impayée</span>
            @endif
        </li>
        <li><span class="font-semibold text-gray-700">Total :</span> <span class="text-gray-900">{{ number_format($facture->total, 2) }} DH</span></li>
    </ul>
    <div class="mb-6">
        <h2 class="font-semibold text-lg mb-2">Lignes de produits</h2>
        <table class="min-w-full bg-white rounded shadow border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2">Produit</th>
                    <th class="p-2">Quantité</th>
                
                </tr>
            </thead>
            <tbody>
                @forelse($facture->lignes as $ligne)
                <tr>
                    <td class="p-2">{{ $ligne->produit->nom ?? '-' }}</td>
                    <td class="p-2">{{ $ligne->quantite }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-gray-400">Aucune ligne</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('factures.index') }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-700">Retour à la liste</a>
        <a href="{{ route('factures.edit', $facture) }}" class="px-4 py-2 rounded bg-yellow-100 text-yellow-800 hover:bg-yellow-200 font-semibold">Modifier</a>
        <a href="{{ route('factures.download', $facture->id) }}" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 font-semibold">Télécharger PDF</a>
        <form action="{{ route('factures.destroy', $facture) }}" method="POST" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded bg-red-100 text-red-700 hover:bg-red-200 font-semibold">Supprimer</button>
        </form>
    </div>
</div>
@endsection 