<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'date', 'total', 'statut_paiement'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function lignes()
    {
        return $this->hasMany(LigneFacture::class);
    }
    public function updateTotal()
    {
        $this->total = $this->lignes->sum('prix_total');
        $this->save();
    }
}
