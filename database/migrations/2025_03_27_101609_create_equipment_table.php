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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id('equipment_id');
            $table->string('description', 50);
            $table->string('equipment_name', 20)->unique();
            $table->char('equipment_unit', length: 5);
        });

        Schema::create('job_has_equipments', function (Blueprint $table) {
            $table->id();
            $table->double('koefisien');
            $table->decimal('total_cost', 10);
            $table->decimal('equipment_cost', 10);
            $table->foreignId('sub_job_id')->references('sub_job_id')->on('sub_jobs')->onDelete('cascade');
            $table->foreignId('equipment_id')->references('equipment_id')->on('equipments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
        Schema::dropIfExists('job_has_equipments');
    }
};
