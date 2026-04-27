<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeProduit extends Model
{
    protected $table = 'type_produits';

    protected $fillable = [
        'nom',
        'slug',
        'description'
    ];

    public function produits()
    {
        return $this->hasMany(Produit::class, 'type_produit_id');
    }
    public function sousTypes()
{
    return $this->hasMany(SousTypeProduit::class);
}
}
