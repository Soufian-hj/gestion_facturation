@extends('layouts.app')

@section('title', 'Liste des Produits')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <h1 class="text-3xl font-extrabold tracking-tight text-gray-800 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0H4" /></svg>
        Produits
    </h1>
    <a href="{{ route('produits.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-700 text-white px-6 py-2 rounded-lg shadow hover:from-blue-600 hover:to-blue-800 font-semibold transition">+ Nouveau Produit</a>
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
            <th class="p-3 text-left font-semibold text-gray-700">Nom</th>
            <th class="p-3 text-left font-semibold text-gray-700">Prix Unitaire</th>
            <th class="p-3 text-center font-semibold text-gray-700">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produits as $produit)
        <tr class="border-t border-gray-100 hover:bg-blue-50 transition">
            <td class="p-3 text-gray-800 font-medium">{{ $produit->nom }}</td>
            <td class="p-3 text-gray-900 font-bold">{{ number_format($produit->prix_unitaire, 2) }} DH</td>
            <td class="p-3 text-center">
                <div class="flex flex-col md:flex-row gap-2 justify-center items-center">
                    <a href="{{ route('produits.edit', $produit) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200 font-medium transition" title="Modifier">
                        ✏️ Modifier
                    </a>
                    <form action="{{ route('produits.destroy', $produit) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')" class="inline">
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
