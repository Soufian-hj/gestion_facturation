<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LigneFacture extends Model
{
    use HasFactory;

    protected $fillable = ['facture_id', 'produit_id', 'quantite', 'prix_total'];

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}