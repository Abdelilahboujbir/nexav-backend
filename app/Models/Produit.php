<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $table = 'produits';

    protected $fillable = [
        'type_produit_id',
        'sous_type_produit_id',
        'nom',
        'slug',
        'description_courte',
        'description_longue',
        'image_principale',
        'video_url',
        'actif'
    ];

    public function typeProduit()
    {
        return $this->belongsTo(TypeProduit::class, 'type_produit_id');
    }

    public function sousTypeProduit()
    {
        return $this->belongsTo(SousTypeProduit::class, 'sous_type_produit_id');
    }

    public function mediaProduits()
    {
        return $this->hasMany(MediaProduit::class, 'produit_id');
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class, 'produit_id');
    }
}
