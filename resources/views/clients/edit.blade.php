@extends('layouts.app')
@section('title', 'modifier Clients')
@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Modifier client</h1>

    <form action="{{ route('clients.update', $client) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium">Nom</label>
            <input type="text" name="nom" value="{{ $client->nom }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Adresse</label>
            <input type="text" name="adresse" value="{{ $client->adresse }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Téléphone</label>
            <input type="text" name="téléphone" value="{{ $client->téléphone }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ $client->email }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Mettre à jour</button>
            <a href="{{ route('clients.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
        </div>
    </form>
</div>
@endsection
