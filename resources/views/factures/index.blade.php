@extends('layouts.app')

@section('title', 'Liste des Factures')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <h1 class="text-3xl font-extrabold tracking-tight text-gray-800 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2v-6a2 2 0 00-2-2h-2a2 2 0 00-2 2v6a2 2 0 002 2z" /></svg>
        Factures
    </h1>
    <a href="{{ route('factures.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-700 text-white px-6 py-2 rounded-lg shadow hover:from-blue-600 hover:to-blue-800 font-semibold transition">+ Nouvelle Facture</a>
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
            <th class="p-3 text-left font-semibold text-gray-700">N° Facture</th>
            <th class="p-3 text-left font-semibold text-gray-700">Client</th>
            <th class="p-3 text-left font-semibold text-gray-700">Date</th>
            <th class="p-3 text-left font-semibold text-gray-700">Total</th>
            <th class="p-3 text-left font-semibold text-gray-700">Statut</th>
            <th class="p-3 text-center font-semibold text-gray-700">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($factures as $facture)
        <tr class="border-t border-gray-100 hover:bg-blue-50 transition">
            <td class="p-3 text-gray-800 font-semibold">{{ $facture->id }}</td>
            <td class="p-3 text-gray-800 font-medium">{{ $facture->client->nom }}</td>
            <td class="p-3 text-gray-600">{{ $facture->date }}</td>
            <td class="p-3 text-gray-900 font-bold">{{ number_format($facture->total, 2) }} DH</td>
            <td class="p-3">
                @if($facture->statut_paiement === 'payé')
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 border border-green-300">Payée</span>
                @elseif($facture->statut_paiement === 'en attente')
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-300">En attente</span>
                @else
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700 border border-red-300">Impayée</span>
                @endif
            </td>
            <td class="p-3 text-center">
                <div class="flex flex-col md:flex-row gap-2 justify-center items-center">
                    <a href="{{ route('factures.show', $facture) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 text-gray-800 rounded hover:bg-gray-200 font-medium transition" title="Voir">👁️ Voir</a>
                    <a href="{{ route('factures.edit', $facture) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200 font-medium transition" title="Modifier">
                        ✏️ Modifier
                    </a>
                    <a href="{{ route('factures.download', $facture->id) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium shadow transition" title="Télécharger PDF">
                        📄 PDF
                    </a>
                    <form method="POST" action="{{ route('factures.destroy', $facture) }}" onsubmit="return confirm('Supprimer ?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 font-medium transition" title="Supprimer">
                            🗑️ Supprimer
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
