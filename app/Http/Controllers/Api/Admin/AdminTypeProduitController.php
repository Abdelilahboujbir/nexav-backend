<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeProduit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminTypeProduitController extends Controller
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

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $slug = Str::slug($request->nom);
        $originalSlug = $slug;
        $count = 1;

        while (TypeProduit::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $type = TypeProduit::create([
            'nom' => $request->nom,
            'slug' => $slug,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'Type de produit ajouté avec succès',
            'type' => $type
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $type = TypeProduit::find($id);

        if (!$type) {
            return response()->json([
                'message' => 'Type de produit introuvable'
            ], 404);
        }

        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $slug = $type->slug;

        if ($request->nom !== $type->nom) {
            $slug = Str::slug($request->nom);
            $originalSlug = $slug;
            $count = 1;

            while (TypeProduit::where('slug', $slug)->where('id', '!=', $type->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
        }

        $type->update([
            'nom' => $request->nom,
            'slug' => $slug,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'Type de produit modifié avec succès',
            'type' => $type
        ], 200);
    }

    public function destroy($id)
    {
        $type = TypeProduit::find($id);

        if (!$type) {
            return response()->json([
                'message' => 'Type de produit introuvable'
            ], 404);
        }

        $type->delete();

        return response()->json([
            'message' => 'Type de produit supprimé avec succès'
        ], 200);
    }
}
