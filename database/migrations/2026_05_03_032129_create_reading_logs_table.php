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
        Schema::create('reading_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reading_progress_id')->constrained()->on('reading_progress');
            $table->date('date_read');
            $table->integer('start_page');
            $table->integer('end_page');
            $table->integer('total_page_read');
            $table->text('summary');
            $table->boolean('verified')->default(false);
            $table->foreignId('teacher_id')->nullable();
            $table->text('teacher_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reading_logs');
    }
};
