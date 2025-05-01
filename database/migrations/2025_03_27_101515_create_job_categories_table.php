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
        Schema::create('job_categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('category_name',);
        });

        Schema::create('house_has_jobs', function (Blueprint $table) {
            $table->id('id');
            $table->decimal('total_cost', 11)->nullable();
            $table->foreignId('house_id')->constrained('houses', 'house_id')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('job_categories', 'category_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_categories');
    }
};
