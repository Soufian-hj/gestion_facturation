@extends('layouts.app')

@section('title', 'Modifier Bon de Livraison')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-200 mt-8">
    <h1 class="text-2xl font-bold mb-6 text-blue-700 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2v-6a2 2 0 00-2-2h-2a2 2 0 00-2 2v6a2 2 0 002 2z" /></svg>
        Modifier Bon de Livraison
    </h1>
    <form action="{{ route('bon_livraisons.update', $bonLivraison->idBL) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-semibold mb-1">Numéro BL</label>
            <input type="text" name="numeroBL" value="{{ old('numeroBL', $bonLivraison->numeroBL) }}" class="w-full border rounded px-3 py-2 bg-gray-50 text-gray-700 font-mono" readonly>
            <p class="text-sm text-gray-500 mt-1">Numéro BL non modifiable</p>
        </div>
        <div>
            <label class="block font-semibold mb-1">Date</label>
            <input type="date" name="date" value="{{ old('date', $bonLivraison->date) }}" class="w-full border rounded px-3 py-2 @error('date') border-red-500 @enderror" required>
            @error('date')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block font-semibold mb-1">Devis</label>
            <select name="devi_id" class="w-full border rounded px-3 py-2 @error('devi_id') border-red-500 @enderror" required>
                <option value="">-- Sélectionner --</option>
                @foreach($devis as $devi)
                    <option value="{{ $devi->id }}" {{ old('devi_id', $bonLivraison->devi_id) == $devi->id ? 'selected' : '' }}>
                        Devis #{{ $devi->id }} - {{ $devi->client->nom ?? 'Client inconnu' }}
                    </option>
                @endforeach
            </select>
            @error('devi_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block font-semibold mb-1">Client</label>
            <select name="client_id" class="w-full border rounded px-3 py-2 @error('client_id') border-red-500 @enderror" required>
                <option value="">-- Sélectionner --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id', $bonLivraison->client_id) == $client->id ? 'selected' : '' }}>
                        {{ $client->nom }} - {{ $client->email }}
                    </option>
                @endforeach
            </select>
            @error('client_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block font-semibold mb-1">Statut</label>
            <select name="statut" class="w-full border rounded px-3 py-2 @error('statut') border-red-500 @enderror">
                <option value="en_preparation" {{ old('statut', $bonLivraison->statut) == 'en_preparation' ? 'selected' : '' }}>En préparation</option>
                <option value="pret" {{ old('statut', $bonLivraison->statut) == 'pret' ? 'selected' : '' }}>Prêt</option>
                <option value="livre" {{ old('statut', $bonLivraison->statut) == 'livre' ? 'selected' : '' }}>Livré</option>
                <option value="annule" {{ old('statut', $bonLivraison->statut) == 'annule' ? 'selected' : '' }}>Annulé</option>
            </select>
            @error('statut')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('bon_livraisons.index') }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 text-gray-700">Annuler</a>
            <button type="submit" class="px-6 py-2 rounded bg-blue-600 text-white font-semibold hover:bg-blue-700">Enregistrer</button>
        </div>
    </form>
</div>
@endsection 