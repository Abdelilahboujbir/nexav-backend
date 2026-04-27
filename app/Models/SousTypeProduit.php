<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SousTypeProduit extends Model
{
    protected $table = 'sous_type_produits';

    protected $fillable = [
        'type_produit_id',
        'nom',
        'slug',
        'description'
    ];

    public function typeProduit()
    {
        return $this->belongsTo(TypeProduit::class, 'type_produit_id');
    }

    public function produits()
    {
        return $this->hasMany(Produit::class, 'sous_type_produit_id');
    }
}
