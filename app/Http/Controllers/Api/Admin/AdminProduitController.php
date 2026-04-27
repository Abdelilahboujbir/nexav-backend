<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::with(['typeProduit', 'sousTypeProduit', 'mediaProduits'])->get();

        return response()->json([
            'message' => 'Liste des produits',
            'produits' => $produits
        ], 200);
    }

    public function show($id)
    {
        $produit = Produit::with(['typeProduit', 'sousTypeProduit', 'mediaProduits'])->find($id);

        if (!$produit) {
            return response()->json(['message' => 'Produit introuvable'], 404);
        }

        return response()->json([
            'message' => 'Détail du produit',
            'produit' => $produit
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_produit_id' => 'required|exists:type_produits,id',
            'sous_type_produit_id' => 'nullable|exists:sous_type_produits,id',
            'nom' => 'required|string|max:255',
            'description_courte' => 'nullable|string',
            'description_longue' => 'nullable|string',
            'image_principale' => 'nullable|mimes:jpg,jpeg,png,avif,webp|max:2048',
            'video_url' => 'nullable|string',
            'actif' => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->nom);
        $originalSlug = $slug;
        $count = 1;

        while (Produit::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $imagePath = null;

        if ($request->hasFile('image_principale')) {
            $imagePath = $request->file('image_principale')->store('produits', 'public');
        }

        $produit = Produit::create([
            'type_produit_id' => $request->type_produit_id,
            'sous_type_produit_id' => $request->sous_type_produit_id ?: null,
            'nom' => $request->nom,
            'slug' => $slug,
            'description_courte' => $request->description_courte,
            'description_longue' => $request->description_longue,
            'image_principale' => $imagePath,
            'video_url' => $request->video_url,
            'actif' => $request->actif ?? true,
        ]);

        return response()->json([
            'message' => 'Produit ajouté avec succès',
            'produit' => $produit
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json(['message' => 'Produit introuvable'], 404);
        }

        $request->validate([
            'type_produit_id' => 'required|exists:type_produits,id',
            'sous_type_produit_id' => 'nullable|exists:sous_type_produits,id',
            'nom' => 'required|string|max:255',
            'description_courte' => 'nullable|string',
            'description_longue' => 'nullable|string',
            'image_principale' => 'nullable|mimes:jpg,jpeg,png,avif,webp|max:2048',
            'video_url' => 'nullable|string',
            'actif' => 'nullable|boolean',
        ]);

        $slug = $produit->slug;

        if ($request->nom !== $produit->nom) {
            $slug = Str::slug($request->nom);
            $originalSlug = $slug;
            $count = 1;

            while (Produit::where('slug', $slug)->where('id', '!=', $produit->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
        }

        $imagePath = $produit->image_principale;

        if ($request->hasFile('image_principale')) {
            if ($produit->image_principale && Storage::disk('public')->exists($produit->image_principale)) {
                Storage::disk('public')->delete($produit->image_principale);
            }

            $imagePath = $request->file('image_principale')->store('produits', 'public');
        }

        $produit->update([
            'type_produit_id' => $request->type_produit_id,
            'sous_type_produit_id' => $request->sous_type_produit_id ?: null,
            'nom' => $request->nom,
            'slug' => $slug,
            'description_courte' => $request->description_courte,
            'description_longue' => $request->description_longue,
            'image_principale' => $imagePath,
            'video_url' => $request->video_url,
            'actif' => $request->has('actif') ? $request->actif : $produit->actif,
        ]);

        return response()->json([
            'message' => 'Produit modifié avec succès',
            'produit' => $produit
        ], 200);
    }

    public function destroy($id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json(['message' => 'Produit introuvable'], 404);
        }

        if ($produit->image_principale && Storage::disk('public')->exists($produit->image_principale)) {
            Storage::disk('public')->delete($produit->image_principale);
        }

        $produit->delete();

        return response()->json(['message' => 'Produit supprimé avec succès'], 200);
    }
}
