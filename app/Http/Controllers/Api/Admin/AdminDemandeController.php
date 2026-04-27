<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use Illuminate\Http\Request;

class AdminDemandeController extends Controller
{
    public function index()
    {
        $demandes = Demande::with('produit')->latest()->get();

        return response()->json([
            'message' => 'Liste des demandes',
            'demandes' => $demandes
        ], 200);
    }

    public function show($id)
    {
        $demande = Demande::with('produit')->find($id);

        if (!$demande) {
            return response()->json([
                'message' => 'Demande introuvable'
            ], 404);
        }

        return response()->json([
            'message' => 'Détail de la demande',
            'demande' => $demande
        ], 200);
    }

    public function updateStatut(Request $request, $id)
    {
        $demande = Demande::find($id);

        if (!$demande) {
            return response()->json([
                'message' => 'Demande introuvable'
            ], 404);
        }

        $request->validate([
            'statut' => 'required|in:nouveau,lu,traite'
        ]);

        $demande->update([
            'statut' => $request->statut
        ]);

        return response()->json([
            'message' => 'Statut de la demande mis à jour avec succès',
            'demande' => $demande
        ], 200);
    }

    public function destroy($id)
    {
        $demande = Demande::find($id);

        if (!$demande) {
            return response()->json([
                'message' => 'Demande introuvable'
            ], 404);
        }

        $demande->delete();

        return response()->json([
            'message' => 'Demande supprimée avec succès'
        ], 200);
    }
}
