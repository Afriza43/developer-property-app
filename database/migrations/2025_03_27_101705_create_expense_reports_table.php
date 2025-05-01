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
        Schema::create('expense_reports', function (Blueprint $table) {
            $table->id('expense_id');
            $table->string('description', 50);
            $table->decimal('total_expense', 10);
            $table->string('evidence');
            $table->foreignId('house_id')->references('house_id')->on('houses')->onDelete('cascade');
            $table->date('purchase_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_reports');
    }
};
