<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TypeProduit;
use App\Models\SousTypeProduit;

class SousTypeProduitController extends Controller
{
    public function index()
{
    $sousTypes = \App\Models\SousTypeProduit::with('typeProduit')->get();

    return response()->json([
        'message' => 'Liste des sous-types',
        'sous_types' => $sousTypes
    ], 200);
}
    public function byType($slug)
    {
        $type = TypeProduit::where('slug', $slug)->first();

        if (!$type) {
            return response()->json([
                'message' => 'Type de produit introuvable'
            ], 404);
        }

        $sousTypes = SousTypeProduit::where('type_produit_id', $type->id)
            ->with('produits')
            ->get();

        return response()->json([
            'message' => 'Liste des sous-types',
            'type' => $type,
            'sous_types' => $sousTypes
        ], 200);
    }
}
