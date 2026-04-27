<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use Illuminate\Http\Request;

class DemandeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'produit_id' => 'nullable|exists:produits,id',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:30',
            'raison_sociale' => 'required|string|max:255',
            'secteur' => 'required|string|max:255',
            'nombre_ecrans' => 'required|string|max:50',
            'question' => 'required|string'
        ]);

        $demande = Demande::create([
            'produit_id' => $request->produit_id,
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'raison_sociale' => $request->raison_sociale,
            'secteur' => $request->secteur,
            'nombre_ecrans' => $request->nombre_ecrans,
            'question' => $request->question,
            'statut' => 'nouveau'
        ]);

        return response()->json([
            'message' => 'Demande envoyée avec succès',
            'demande' => $demande
        ], 201);
    }
}
