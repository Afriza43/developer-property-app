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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employee_id');
            $table->string('position', 25);
            $table->char('unit', length: 5);
        });

        Schema::create('job_has_employees', function (Blueprint $table) {
            $table->id();
            $table->double('koefisien');
            $table->decimal('total_cost', 10);
            $table->foreignId('job_id')->references('job_id')->on('jobs')->onDelete('cascade');
            $table->foreignId('employee_id')->references('employee_id')->on('employees')->onDelete('cascade');
            $table->decimal('wage', 10);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
