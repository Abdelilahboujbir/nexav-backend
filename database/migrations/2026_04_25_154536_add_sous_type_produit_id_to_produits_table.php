<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
{
    Schema::table('produits', function (Blueprint $table) {
        if (!Schema::hasColumn('produits', 'sous_type_produit_id')) {
            $table->foreignId('sous_type_produit_id')
                ->nullable()
                ->after('type_produit_id');
        }
    });

    Schema::table('produits', function (Blueprint $table) {
        $table->foreign('sous_type_produit_id')
            ->references('id')
            ->on('sous_type_produits')
            ->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('produits', function (Blueprint $table) {
        $table->dropForeign(['sous_type_produit_id']);
        $table->dropColumn('sous_type_produit_id');
    });
}
};
