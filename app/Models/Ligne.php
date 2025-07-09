<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ligne extends Model
{
    protected $fillable = ['devis_id', 'produit_id', 'quantite', 'prix_unitaire'];

    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function total()
    {
        return $this->quantite * $this->prix_unitaire;
    }
}
