<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TypeProduit;

class TypeProduitController extends Controller
{
    public function index()
    {
        $types = TypeProduit::with('produits')->get();

        return response()->json([
            'message' => 'Liste des types de produits',
            'types' => $types
        ], 200);
    }

    public function show($id)
    {
        $type = TypeProduit::with('produits')->find($id);

        if (!$type) {
            return response()->json([
                'message' => 'Type de produit introuvable'
            ], 404);
        }

        return response()->json([
            'message' => 'Détail du type de produit',
            'type' => $type
        ], 200);
    }
}
