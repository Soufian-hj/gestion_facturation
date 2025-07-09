@extends('layouts.app')

@section('title', 'Lignes de Facture')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <h1 class="text-3xl font-extrabold tracking-tight text-gray-800 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2v-6a2 2 0 00-2-2h-2a2 2 0 00-2 2v6a2 2 0 002 2z" /></svg>
        Lignes de Facture
    </h1>
    <a href="{{ route('ligne_factures.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-700 text-white px-6 py-2 rounded-lg shadow hover:from-blue-600 hover:to-blue-800 font-semibold transition">+ Nouvelle Ligne</a>
</div>
@if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-6 border-l-4 border-green-500 shadow">
        {{ session('success') }}
    </div>
    </div>
@endif
<div class="overflow-x-auto">
<table class="min-w-full bg-white rounded-xl shadow-lg border border-gray-200">
    <thead class="bg-gradient-to-r from-gray-100 to-gray-200">
        <tr>
            <th class="p-3 text-left font-semibold text-gray-700">Facture</th>
            <th class="p-3 text-left font-semibold text-gray-700">Produit</th>
            <th class="p-3 text-left font-semibold text-gray-700">Quantité</th>
            <th class="p-3 text-left font-semibold text-gray-700">Prix Total</th>
            <th class="p-3 text-center font-semibold text-gray-700">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lignes as $ligne)
        <tr class="border-t border-gray-100 hover:bg-blue-50 transition">
            <td class="p-3 text-gray-800 font-medium">{{ $ligne->facture->id }}</td>
            <td class="p-3 text-gray-600">{{ $ligne->produit->nom }}</td>
            <td class="p-3 text-gray-900 font-bold">{{ $ligne->quantite }}</td>
            <td class="p-3 text-gray-900 font-bold">{{ number_format($ligne->prix_total, 2) }} DH</td>
            <td class="p-3 text-center">
                <div class="flex flex-col md:flex-row gap-2 justify-center items-center">
                    <a href="{{ route('ligne_factures.edit', $ligne) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200 font-medium transition" title="Modifier">
                        ✏️ Modifier
                    </a>
                    <form action="{{ route('ligne_factures.destroy', $ligne) }}" method="POST" onsubmit="return confirm('Supprimer ?')" class="inline">
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
