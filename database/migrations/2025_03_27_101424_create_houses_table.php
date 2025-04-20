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
        Schema::create('houses', function (Blueprint $table) {
            $table->id('house_id');
            $table->string('name', 25);
            $table->integer('block_number');
            $table->integer('type');
            $table->decimal('total_cost', 12)->nullable();
            $table->string('image')->nullable();
            $table->string('password')->nullable();
            $table->foreignId('project_id')->constrained('projects', 'project_id')->onDelete('cascade');
        });

        Schema::create('user_has_houses', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->foreignId('house_id')->constrained('houses', 'house_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
