<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\TypeProduit;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::with(['typeProduit', 'mediaProduits'])
            ->where('actif', true)
            ->get();

        return response()->json([
            'message' => 'Liste des produits',
            'produits' => $produits
        ], 200);
    }

    public function show($id)
    {
        $produit = Produit::with(['typeProduit', 'mediaProduits'])
            ->where('actif', true)
            ->find($id);

        if (!$produit) {
            return response()->json([
                'message' => 'Produit introuvable'
            ], 404);
        }

        return response()->json([
            'message' => 'Détail du produit',
            'produit' => $produit
        ], 200);
    }

    public function produitsParType($slug)
    {
        $type = TypeProduit::where('slug', $slug)->first();

        if (!$type) {
            return response()->json([
                'message' => 'Type de produit introuvable'
            ], 404);
        }

        $produits = Produit::with(['typeProduit', 'mediaProduits'])
            ->where('type_produit_id', $type->id)
            ->where('actif', true)
            ->get();

        return response()->json([
            'message' => 'Produits du type sélectionné',
            'type' => $type,
            'produits' => $produits
        ], 200);
    }
}
