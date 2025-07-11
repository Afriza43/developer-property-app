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
            $table->string('name', 11)->unique();
            $table->string('block', 8);
            $table->char('number', 2);
            $table->string('type', 8);
            $table->decimal('house_cost', 11)->nullable();
            $table->foreignId('project_id')->constrained('projects', 'project_id')->onDelete('cascade');
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
