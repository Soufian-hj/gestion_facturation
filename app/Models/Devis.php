<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    protected $fillable = ['client_id', 'etat', 'date'];

    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class);
    }

    public function lignes()
    {
        return $this->hasMany(\App\Models\Ligne::class);
    }
}
