@extends('layouts.app')

@section('title', 'Ajouter Facture')

@section('content')
<h1 class="text-2xl font-bold mb-6">Nouvelle Facture</h1>

<form action="{{ route('factures.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label>Client</label>
        <select name="client_id" class="w-full border rounded px-3 py-2" required>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}">{{ $client->nom }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Date</label>
        <input type="date" name="date" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
        <label>Total</label>
        <input type="number" name="total" step="0.01" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
        <label>Statut Paiement</label>
        <select name="statut_paiement" class="w-full border rounded px-3 py-2" required>
            <option value="payé">Payé</option>
            <option value="en attente">En attente</option>
            <option value="annulé">Annulé</option>
        </select>
    </div>

    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Enregistrer</button>
</form>
@endsection
