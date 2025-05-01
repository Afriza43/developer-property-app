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
            $table->double('total_volume')->nullable();
            $table->char('satuan_volume', 5)->nullable();
        });

        Schema::create('sub_jobs', function (Blueprint $table) {
            $table->id('id');
            $table->decimal('job_cost', 11)->nullable();
            $table->foreignId('category_id')->constrained('job_categories', 'category_id')->onDelete('cascade');
            $table->foreignId('job_id')->constrained('jobs', 'job_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('sub_jobs');
    }
};
