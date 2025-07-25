<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prix_unitaire'];
    public function lignes()
    {
        return $this->hasMany(LigneFacture::class);
    }

}
