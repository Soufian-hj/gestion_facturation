@extends('layouts.app')

@section('title', 'Modifier Ligne')

@section('content')
<h1 class="text-2xl font-bold mb-4">Modifier Ligne de Facture</h1>

<form action="{{ route('ligne_factures.update', $ligne_facture) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label>Facture</label>
        <select name="facture_id" class="w-full border rounded px-3 py-2" required>
            @foreach ($factures as $facture)
                <option value="{{ $facture->id }}" {{ $facture->id == $ligne_facture->facture_id ? 'selected' : '' }}>Facture #{{ $facture->id }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Produit</label>
        <select name="produit_id" class="w-full border rounded px-3 py-2" required>
            @foreach ($produits as $produit)
                <option value="{{ $produit->id }}" {{ $produit->id == $ligne_facture->produit_id ? 'selected' : '' }}>{{ $produit->nom }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Quantité</label>
        <input type="number" name="quantite" value="{{ $ligne_facture->quantite }}" min="1" class="w-full border px-3 py-2 rounded" required>
    </div>

    <button class="bg-green-500 text-white px-4 py-2 rounded">Mettre à jour</button>
</form>
@endsection
