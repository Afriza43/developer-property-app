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
        Schema::create('volume_items', function (Blueprint $table) {
            $table->id('volume_items_id');
            $table->string('description', 50);
            $table->double('amount');
            $table->double('length');
            $table->double('width');
            $table->double('height');
            $table->double('wide');
            $table->double('volume_per_unit');
            $table->foreignId('job_id')->references('job_id')->on('jobs')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volume_items');
    }
};
