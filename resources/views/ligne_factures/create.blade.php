@extends('layouts.app')

@section('title', 'Ajouter Ligne')

@section('content')
<h1 class="text-2xl font-bold mb-4">Ajouter une Ligne de Facture</h1>

<form action="{{ route('ligne_factures.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label>Facture</label>
        <select name="facture_id" class="w-full border rounded px-3 py-2" required>
            @foreach ($factures as $facture)
                <option value="{{ $facture->id }}">Facture #{{ $facture->id }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Produit</label>
        <select name="produit_id" class="w-full border rounded px-3 py-2" required>
            @foreach ($produits as $produit)
                <option value="{{ $produit->id }}">{{ $produit->nom }} ({{ $produit->prix_unitaire }} DH)</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Quantité</label>
        <input type="number" name="quantite" min="1" class="w-full border px-3 py-2 rounded" required>
    </div>

    <button class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
</form>
@endsection
