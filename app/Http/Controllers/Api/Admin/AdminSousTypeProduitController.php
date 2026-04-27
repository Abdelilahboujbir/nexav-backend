<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SousTypeProduit;
use App\Models\TypeProduit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSousTypeProduitController extends Controller
{
    public function index()
    {
        $sousTypes = SousTypeProduit::with('typeProduit')->get();

        return response()->json([
            'message' => 'Liste des sous-types de produits',
            'sous_types' => $sousTypes
        ], 200);
    }

    public function show($id)
    {
        $sousType = SousTypeProduit::with(['typeProduit', 'produits'])->find($id);

        if (!$sousType) {
            return response()->json([
                'message' => 'Sous-type introuvable'
            ], 404);
        }

        return response()->json([
            'message' => 'Détail du sous-type',
            'sous_type' => $sousType
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_produit_id' => 'required|exists:type_produits,id',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $slug = Str::slug($request->nom);
        $originalSlug = $slug;
        $count = 1;

        while (SousTypeProduit::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $sousType = SousTypeProduit::create([
            'type_produit_id' => $request->type_produit_id,
            'nom' => $request->nom,
            'slug' => $slug,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'Sous-type ajouté avec succès',
            'sous_type' => $sousType
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $sousType = SousTypeProduit::find($id);

        if (!$sousType) {
            return response()->json([
                'message' => 'Sous-type introuvable'
            ], 404);
        }

        $request->validate([
            'type_produit_id' => 'required|exists:type_produits,id',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $slug = $sousType->slug;

        if ($request->nom !== $sousType->nom) {
            $slug = Str::slug($request->nom);
            $originalSlug = $slug;
            $count = 1;

            while (SousTypeProduit::where('slug', $slug)->where('id', '!=', $sousType->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
        }

        $sousType->update([
            'type_produit_id' => $request->type_produit_id,
            'nom' => $request->nom,
            'slug' => $slug,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'Sous-type modifié avec succès',
            'sous_type' => $sousType
        ], 200);
    }

    public function destroy($id)
    {
        $sousType = SousTypeProduit::find($id);

        if (!$sousType) {
            return response()->json([
                'message' => 'Sous-type introuvable'
            ], 404);
        }

        $sousType->delete();

        return response()->json([
            'message' => 'Sous-type supprimé avec succès'
        ], 200);
    }
}
