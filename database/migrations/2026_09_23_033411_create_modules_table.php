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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();        // kuantitatif, kualitatif, pga, farmasi, clinical_pathway
            $table->string('label');                 // Kuantitatif (DDD)
            $table->string('route_prefix');           // kuantitatif.index
            $table->string('icon')->nullable();       // fa-solid fa-chart-column
            $table->integer('sidebar_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
