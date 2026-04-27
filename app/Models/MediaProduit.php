<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaProduit extends Model
{
    protected $table = 'media_produits';

    protected $fillable = [
        'produit_id',
        'chemin_media',
        'type_media'
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
}
