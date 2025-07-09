@extends('layouts.app')

@section('title', 'Liste des Devis')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <h1 class="text-3xl font-extrabold tracking-tight text-gray-800 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2v-6a2 2 0 00-2-2h-2a2 2 0 00-2 2v6a2 2 0 002 2z" /></svg>
        Devis
    </h1>
    <a href="{{ route('devis.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-700 text-white px-6 py-2 rounded-lg shadow hover:from-blue-600 hover:to-blue-800 font-semibold transition">+ Nouveau Devis</a>
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
            <th class="p-3 text-left font-semibold text-gray-700">Client</th>
            <th class="p-3 text-left font-semibold text-gray-700">Date</th>
            <th class="p-3 text-left font-semibold text-gray-700">Total</th>
            <th class="p-3 text-left font-semibold text-gray-700">Statut</th>
            <th class="p-3 text-center font-semibold text-gray-700">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($devis as $devis)
        <tr class="border-t border-gray-100 hover:bg-blue-50 transition">
            <td class="p-3 text-gray-800 font-medium">{{ $devis->client->nom ?? '-' }}</td>
            <td class="p-3 text-gray-600">{{ $devis->date }}</td>
            <td class="p-3 text-gray-900 font-bold">{{ number_format($devis->lignes->sum(function($l){return $l->prix_unitaire * $l->quantite;}), 2) }} DH</td>
            <td class="p-3">
                @php
                    $etat = strtolower(str_replace(['é','É','_'], ['e','e',''], $devis->etat));
                @endphp
                @if($etat === 'accepte')
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-300">Accepté</span>
                @elseif($etat === 'refuse')
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700 border border-red-300">Refusé</span>
                @else
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-300">En attente</span>
                @endif
            </td>
            <td class="p-3 text-center">
                <div class="flex flex-col md:flex-row gap-2 justify-center items-center">
                    <a href="{{ route('devis.show', ['devis' => $devis->id]) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 text-gray-800 rounded hover:bg-gray-200 font-medium transition" title="Voir">👁️ Voir</a>
                    <a href="{{ route('devis.edit', ['devis' => $devis->id]) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200 font-medium transition" title="Modifier">
                        ✏️ Modifier
                    </a>
                    <a href="{{ route('devis.downloadPDF', $devis->id) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium shadow transition" title="Télécharger PDF">
                        📄 PDF
                    </a>
                    <form method="POST" action="{{ route('devis.destroy', ['devis' => $devis->id]) }}" onsubmit="return confirm('Supprimer ?')" class="inline">
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
            <td colspan="5" class="p-4 text-center text-gray-500">Aucun devis trouvé.</td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection