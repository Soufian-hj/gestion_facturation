@extends('layouts.app')

@section('title', 'Modifier le Produit')

@section('content')
<h1 class="text-2xl font-bold mb-6">Modifier le Produit</h1>

<form action="{{ route('produits.update', $produit) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium">Nom</label>
        <input type="text" name="nom" value="{{ $produit->nom }}" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
        <label class="block text-sm font-medium">Prix Unitaire</label>
        <input type="number" name="prix_unitaire" step="0.01" value="{{ $produit->prix_unitaire }}" class="w-full border rounded px-3 py-2" required>
    </div>

    <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Mettre à jour</button>
</form>
@endsection
