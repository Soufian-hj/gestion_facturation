@extends('layouts.app')

@section('title', 'Détail du Devis')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded shadow p-6 mt-8">
    <h1 class="text-2xl font-bold mb-4">Détail du Devis</h1>
    <div class="mb-4">
        <strong>ID :</strong> {{ $devis->id }}<br>
        <strong>Date :</strong> {{ $devis->date }}<br>
        @php
            $etat = strtolower(str_replace(['é','É','_'], ['e','e',''], $devis->etat));
        @endphp
        <strong>Statut :</strong>
        @if($etat === 'accepte')
            <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-300">Accepté</span>
        @elseif($etat === 'refuse')
            <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700 border border-red-300">Refusé</span>
        @else
            <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-300">En attente</span>
        @endif
        <br>
        <strong>Client :</strong> {{ $devis->client->nom ?? '-' }}
    </div>
    <h2 class="text-xl font-semibold mb-2">Lignes du devis</h2>
    <table class="min-w-full bg-white rounded shadow border mb-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2">Produit</th>
                <th class="p-2">Quantité</th>
                <th class="p-2">Prix unitaire</th>
                <th class="p-2">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devis->lignes as $ligne)
                <tr>
                    <td>{{ $ligne->produit->nom ?? '-' }}</td>
                    <td>{{ $ligne->quantite }}</td>
                    <td>{{ number_format($ligne->prix_unitaire, 2) }} MAD</td>
                    <td>{{ number_format($ligne->total(), 2) }} MAD</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4 text-right">
        <strong>Total du devis : </strong>
        {{ number_format($devis->lignes->sum(function($l){return $l->total();}), 2) }} MAD
    </div>
    <div class="flex gap-2 mt-6">
        <a href="{{ route('devis.index') }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-700">Retour à la liste</a>
        <a href="{{ route('devis.edit', ['devis' => $devis->id]) }}" class="px-4 py-2 rounded bg-yellow-100 text-yellow-800 hover:bg-yellow-200 font-semibold">Modifier</a>
        <a href="{{ route('devis.downloadPDF', $devis->id) }}" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 font-semibold">Télécharger PDF</a>
        <form action="{{ route('devis.destroy', ['devis' => $devis->id]) }}" method="POST" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded bg-red-100 text-red-700 hover:bg-red-200 font-semibold">Supprimer</button>
        </form>
    </div>
</div>
@endsection
