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
            $table->char('satuan_volume', 5)->nullable();
        });

        Schema::create('project_types', function (Blueprint $table) {
            $table->id('type_id');
            $table->string('name', 15);
            $table->string('type', 8);
            $table->decimal('budget_plan', 12)->nullable();
            $table->string('image')->nullable();
            $table->foreignId('project_id')->constrained('projects', 'project_id')->onDelete('cascade');
        });

        Schema::create('job_types', function (Blueprint $table) {
            $table->id('jobtype_id');
            $table->string('rename', 30)->nullable();
            $table->foreignId('type_id')->constrained('project_types', 'type_id')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('job_categories', 'category_id')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('sub_jobs', function (Blueprint $table) {
            $table->id('sub_job_id');
            $table->decimal('job_cost', 11)->nullable();
            $table->double('total_volume')->nullable();
            $table->string('rename', 30)->nullable();
            $table->foreignId('jobtype_id')->constrained('job_types', 'jobtype_id')->onDelete('cascade');
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
        Schema::dropIfExists('project_types');
        Schema::dropIfExists('job_types');
    }
};
