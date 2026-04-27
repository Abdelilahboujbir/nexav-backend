<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    protected $table = 'demandes';

    protected $fillable = [
        'produit_id',
        'nom',
        'email',
        'telephone',
        'raison_sociale',
        'secteur',
        'nombre_ecrans',
        'question',
        'statut'
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
}
