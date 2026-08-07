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
        Schema::create('kapal_ftit', function (Blueprint $table) {
            $table->string('kode_vessel', 20)->charset('utf8mb4')->collation('utf8mb4_0900_ai_ci');
            $table->string('id_ftit', 10)->charset('utf8mb4')->collation('utf8mb4_0900_ai_ci');

            $table->foreign('kode_vessel')
                  ->references('kode_vessel')->on('kapal')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_ftit')
                  ->references('id_ftit')->on('ftit')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->primary(['kode_vessel', 'id_ftit']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kapal_ftit');
    }
};
