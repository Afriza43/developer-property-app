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
        Schema::create('projects', function (Blueprint $table) {
            $table->id('project_id');
            $table->string('project_name', 35);
            $table->string('location', 15);
            $table->year('year');
            $table->decimal('total_cost', 13)->nullable();
            $table->string('image')->nullable();
        });

        Schema::create('user_access', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->foreignId('project_id')->constrained('projects', 'project_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('user_access');
    }
};
