<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonLivraison extends Model
{
    protected $primaryKey = 'idBL';
    protected $fillable = ['numeroBL', 'date', 'devi_id', 'client_id', 'statut'];

    public function devi() {
        return $this->belongsTo(Devis::class, 'devi_id', 'id');
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function facture() {
        return $this->hasOne(Facture::class, 'bl_id');
    }

    public function lignes() {
        return $this->morphMany(Ligne::class, 'ligneable');
}
}