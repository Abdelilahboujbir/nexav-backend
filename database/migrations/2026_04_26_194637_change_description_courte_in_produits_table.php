<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('produits', function ($table) {
        $table->text('description_courte')->change();
    });
}

public function down()
{
    Schema::table('produits', function ($table) {
        $table->string('description_courte')->change();
    });
}
};
