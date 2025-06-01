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
        Schema::create('progress_reports', function (Blueprint $table) {
            $table->id('progress_reports_id');
            $table->string('description', 50);
            $table->date('report_date');
            $table->integer('period');
            $table->foreignId('house_id')->references('house_id')->on('houses')->onDelete('cascade');
        });

        Schema::create('progress_photos', function (Blueprint $table) {
            $table->id('photo_id');
            $table->string('image', 60);
            $table->foreignId('progress_reports_id')->references('progress_reports_id')->on('progress_reports')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_reports');
        Schema::dropIfExists('progress_photos');
    }
};
