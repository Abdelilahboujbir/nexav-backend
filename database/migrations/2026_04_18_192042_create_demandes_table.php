<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produit_id');
            $table->string('nom');
            $table->string('email');
            $table->string('telephone');
            $table->string('raison_sociale');
            $table->string('secteur');
            $table->integer('nombre_ecrans');
            $table->text('question');
            $table->string('statut')->default('nouveau');
            $table->timestamps();

            $table->foreign('produit_id')
                ->references('id')
                ->on('produits')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
