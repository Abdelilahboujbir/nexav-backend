<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaProduit;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMediaProduitController extends Controller
{
    public function index($produitId)
    {
        $produit = Produit::with('mediaProduits')->find($produitId);

        if (!$produit) {
            return response()->json([
                'message' => 'Produit introuvable'
            ], 404);
        }

        return response()->json([
            'message' => 'Liste des médias du produit',
            'produit' => $produit
        ], 200);
    }

    public function store(Request $request, $produitId)
    {
        $produit = Produit::find($produitId);

        if (!$produit) {
            return response()->json([
                'message' => 'Produit introuvable'
            ], 404);
        }

       $request->validate([
    'media' => 'required|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi,,avif,webm|max:20480',
    'type_media' => 'required|in:image,video'
]);

        $path = $request->file('media')->store('medias_produits', 'public');

        $media = MediaProduit::create([
            'produit_id' => $produit->id,
            'chemin_media' => $path,
            'type_media' => $request->type_media
        ]);

        return response()->json([
            'message' => 'Média ajouté avec succès',
            'media' => $media
        ], 201);
    }

    public function destroy($id)
    {
        $media = MediaProduit::find($id);

        if (!$media) {
            return response()->json([
                'message' => 'Média introuvable'
            ], 404);
        }

        if ($media->chemin_media && Storage::disk('public')->exists($media->chemin_media)) {
            Storage::disk('public')->delete($media->chemin_media);
        }

        $media->delete();

        return response()->json([
            'message' => 'Média supprimé avec succès'
        ], 200);
    }
}
