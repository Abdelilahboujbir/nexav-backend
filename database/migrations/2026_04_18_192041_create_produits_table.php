<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_produit_id');
            $table->string('nom');
            $table->string('slug')->unique();
            $table->string('description_courte')->nullable();
            $table->text('description_longue')->nullable();
            $table->string('image_principale')->nullable();
            $table->string('video_url')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();

            $table->foreign('type_produit_id')
                ->references('id')
                ->on('type_produits')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
