@extends('layouts.app')
@section('title', 'ajouter Clients')
@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Ajouter un client</h1>

    <form action="{{ route('clients.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium">Nom</label>
            <input type="text" name="nom" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Adresse</label>
            <input type="text" name="adresse" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Téléphone</label>
            <input type="text" name="téléphone" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Enregistrer</button>
            <a href="{{ route('clients.index') }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
        </div>
    </form>
</div>
@endsection
