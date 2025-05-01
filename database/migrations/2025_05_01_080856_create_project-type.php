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
        Schema::create('project_types', function (Blueprint $table) {
            $table->id('type_id');
            $table->string('name', 15);
            $table->string('type', 8);
            $table->string('image')->nullable();
            $table->foreignId('project_id')->constrained('projects', 'project_id')->onDelete('cascade');
        });

        Schema::create('rab_type', function (Blueprint $table) {
            $table->id('id');
            $table->decimal('budget_plan', 12)->nullable();
            $table->foreignId('type_id')->constrained('project_types', 'type_id')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('job_categories', 'category_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_types');
        Schema::dropIfExists('rab_type');
    }
};
