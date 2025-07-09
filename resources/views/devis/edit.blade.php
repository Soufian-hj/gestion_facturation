@extends('layouts.app')

@section('title', 'Modifier Devis')

@section('content')
<h1 class="text-2xl font-bold mb-6">Modifier Devis</h1>
<form action="{{ route('devis.update', ['devis' => $devis->id]) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label>Client</label>
        <select name="client_id" class="w-full border rounded px-3 py-2" required>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}" {{ $client->id == $devis->client_id ? 'selected' : '' }}>{{ $client->nom }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Date</label>
        <input type="date" name="date" value="{{ $devis->date }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div>
        <label>Statut du devis</label>
        <select name="etat" class="w-full border rounded px-3 py-2" required>
            <option value="en_attente" {{ $devis->etat == 'en_attente' ? 'selected' : '' }}>En attente</option>
            <option value="accepté" {{ $devis->etat == 'accepté' ? 'selected' : '' }}>Accepté</option>
            <option value="refusé" {{ $devis->etat == 'refusé' ? 'selected' : '' }}>Refusé</option>
        </select>
    </div>
    <div>
        <label class="block font-semibold mb-2">Lignes du devis</label>
        <table class="min-w-full bg-white rounded shadow border mb-4" id="lignes-table">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2">Produit</th>
                    <th class="p-2">Quantité</th>
                    <th class="p-2">Prix unitaire</th>
                    <th class="p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devis->lignes as $i => $ligne)
                <tr>
                    <td>
                        <select name="lignes[{{ $i }}][produit_id]" class="border rounded px-2 py-1" required>
                            <option value="">-- Choisir --</option>
                            @foreach($produits as $produit)
                                <option value="{{ $produit->id }}" {{ $produit->id == $ligne->produit_id ? 'selected' : '' }}>{{ $produit->nom }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="lignes[{{ $i }}][quantite]" class="border rounded px-2 py-1" min="1" value="{{ $ligne->quantite }}" required>
                    </td>
                    <td>
                        <input type="number" name="lignes[{{ $i }}][prix_unitaire]" class="border rounded px-2 py-1" min="0" step="0.01" value="{{ $ligne->prix_unitaire }}" required>
                    </td>
                    <td class="text-center">
                        <button type="button" onclick="removeLigne(this)" class="text-red-500 font-bold">✖</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" onclick="addLigne()" class="bg-blue-100 text-blue-700 px-3 py-1 rounded font-semibold hover:bg-blue-200">+ Ajouter une ligne</button>
    </div>
    <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Mettre à jour</button>
</form>
<script>
let ligneIndex = {{ count($devis->lignes) }};
function addLigne() {
    const table = document.getElementById('lignes-table').getElementsByTagName('tbody')[0];
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>
            <select name="lignes[${ligneIndex}][produit_id]" class="border rounded px-2 py-1" required>
                <option value="">-- Choisir --</option>
                @foreach($produits as $produit)
                    <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" name="lignes[${ligneIndex}][quantite]" class="border rounded px-2 py-1" min="1" value="1" required>
        </td>
        <td>
            <input type="number" name="lignes[${ligneIndex}][prix_unitaire]" class="border rounded px-2 py-1" min="0" step="0.01" required>
        </td>
        <td class="text-center">
            <button type="button" onclick="removeLigne(this)" class="text-red-500 font-bold">✖</button>
        </td>
    `;
    table.appendChild(row);
    ligneIndex++;
}
function removeLigne(btn) {
    const row = btn.closest('tr');
    row.parentNode.removeChild(row);
}
</script>
@endsection 