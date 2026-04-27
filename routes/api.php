<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TypeProduitController;
use App\Http\Controllers\Api\ProduitController;
use App\Http\Controllers\Api\DemandeController;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\AdminProduitController;
use App\Http\Controllers\Api\Admin\AdminDemandeController;
use App\Http\Controllers\Api\Admin\AdminTypeProduitController;
use App\Http\Controllers\Api\Admin\AdminMediaProduitController;
use App\Http\Controllers\Api\SousTypeProduitController;
use App\Http\Controllers\Api\Admin\AdminSousTypeProduitController;

Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/types-produits', [AdminTypeProduitController::class, 'index']);
        Route::get('/types-produits/{id}', [AdminTypeProduitController::class, 'show']);
        Route::post('/types-produits', [AdminTypeProduitController::class, 'store']);
        Route::put('/types-produits/{id}', [AdminTypeProduitController::class, 'update']);
        Route::delete('/types-produits/{id}', [AdminTypeProduitController::class, 'destroy']);

        Route::get('/produits', [AdminProduitController::class, 'index']);
        Route::get('/produits/{id}', [AdminProduitController::class, 'show']);
        Route::post('/produits', [AdminProduitController::class, 'store']);
        Route::put('/produits/{id}', [AdminProduitController::class, 'update']);
        Route::delete('/produits/{id}', [AdminProduitController::class, 'destroy']);

        Route::get('/produits/{produitId}/medias', [AdminMediaProduitController::class, 'index']);
        Route::post('/produits/{produitId}/medias', [AdminMediaProduitController::class, 'store']);
        Route::delete('/medias/{id}', [AdminMediaProduitController::class, 'destroy']);

        Route::get('/demandes', [AdminDemandeController::class, 'index']);
        Route::get('/demandes/{id}', [AdminDemandeController::class, 'show']);
        Route::put('/demandes/{id}/statut', [AdminDemandeController::class, 'updateStatut']);
        Route::delete('/demandes/{id}', [AdminDemandeController::class, 'destroy']);


        Route::apiResource('sous-types-produits', AdminSousTypeProduitController::class);
    });
});

Route::get('/types-produits', [TypeProduitController::class, 'index']);
Route::get('/types-produits/{id}', [TypeProduitController::class, 'show']);
Route::get('/types-produits/{slug}/produits', [ProduitController::class, 'produitsParType']);

Route::get('/produits', [ProduitController::class, 'index']);
Route::get('/produits/{id}', [ProduitController::class, 'show']);

Route::post('/demandes', [DemandeController::class, 'store']);

Route::get('/types-produits/{slug}/sous-types', [SousTypeProduitController::class, 'byType']);

Route::get('/sous-types-produits', [SousTypeProduitController::class, 'index']);
