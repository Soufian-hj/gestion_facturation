@extends('layouts.app')

@section('title', 'Ajouter un Produit')

@section('content')
<h1 class="text-2xl font-bold mb-6">Ajouter un Produit</h1>

<form action="{{ route('produits.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label class="block text-sm font-medium">Nom</label>
        <input type="text" name="nom" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
        <label class="block text-sm font-medium">Prix Unitaire</label>
        <input type="number" name="prix_unitaire" step="0.01" class="w-full border rounded px-3 py-2" required>
    </div>

    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Enregistrer</button>
</form>
@endsection
