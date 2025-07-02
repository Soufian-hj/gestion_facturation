@extends('layouts.app')

@section('title', 'Modifier Facture')

@section('content')
<h1 class="text-2xl font-bold mb-6">Modifier Facture</h1>

<form action="{{ route('factures.update', $facture) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label>Client</label>
        <select name="client_id" class="w-full border rounded px-3 py-2" required>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}" {{ $client->id == $facture->client_id ? 'selected' : '' }}>
                    {{ $client->nom }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Date</label>
        <input type="date" name="date" value="{{ $facture->date }}" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
        <label>Total</label>
        <input type="number" name="total" value="{{ $facture->total }}" step="0.01" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
        <label>Statut Paiement</label>
        <select name="statut_paiement" class="w-full border rounded px-3 py-2" required>
            <option value="payé" {{ $facture->statut_paiement == 'payé' ? 'selected' : '' }}>Payé</option>
            <option value="en attente" {{ $facture->statut_paiement == 'en attente' ? 'selected' : '' }}>En attente</option>
            <option value="annulé" {{ $facture->statut_paiement == 'annulé' ? 'selected' : '' }}>Annulé</option>
        </select>
    </div>

    <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Mettre à jour</button>
</form>
@endsection

