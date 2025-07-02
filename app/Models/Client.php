<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;

class Client extends Model
{
    protected $fillable = [
        'nom',
        'adresse',
        'téléphone',
        'email',
    ];
}
