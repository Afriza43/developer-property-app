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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id('job_id');
            $table->string('job_name', 30);
            $table->decimal('total_cost', 11)->nullable();
            $table->double('total_volume')->nullable();
            $table->char('satuan_volume', 5)->nullable();
            $table->foreignId('category_id')->references('category_id')->on('job_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
