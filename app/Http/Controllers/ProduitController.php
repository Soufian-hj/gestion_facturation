<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::all();
        return view('produits.index', compact('produits'));
    }

    public function create()
    {
        return view('produits.create');
    }

    public function store(Request $request)
    {
        Produit::create($request->all());
        return redirect()->route('produits.index')->with('success', 'Produit ajouté avec succès.');
    }

    public function edit(Produit $produit)
    {
        return view('produits.edit', compact('produit'));
    }

    public function update(Request $request, Produit $produit)
    {
        $produit->update($request->all());
        return redirect()->route('produits.index')->with('success', 'Produit modifié avec succès.');
    }

    public function destroy(Produit $produit)
    {
        $produit->delete();
        return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès.');
    }
}

