<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->dropForeign(['produit_id']);
            $table->unsignedBigInteger('produit_id')->nullable()->change();
            $table->foreign('produit_id')->references('id')->on('produits')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            $table->dropForeign(['produit_id']);
            $table->unsignedBigInteger('produit_id')->nullable(false)->change();
            $table->foreign('produit_id')->references('id')->on('produits')->cascadeOnDelete();
        });
    }
};
