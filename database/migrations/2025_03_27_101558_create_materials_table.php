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
        Schema::create('materials', function (Blueprint $table) {
            $table->id('material_id');
            $table->string('material_name', 25);
            $table->string('description', 50);
            $table->char('material_unit', length: 5);
        });

        Schema::create('job_has_materials', function (Blueprint $table) {
            $table->id();
            $table->double('koefisien');
            $table->decimal('total_cost', 10);
            $table->decimal('material_cost', 10);
            $table->foreignId('job_id')->references('job_id')->on('jobs')->onDelete('cascade');
            $table->foreignId('material_id')->references('material_id')->on('materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
        Schema::dropIfExists('job_has_materials');
    }
};
