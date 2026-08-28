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
        Schema::create('point_log_details', function (Blueprint $table) {
           $table->id();
            $table->foreignId('point_log_id');
            $table->foreignId('student_id');
            $table->date('occurrence_date');
            $table->foreignId('conduct_rule_id')->constrained();
            $table->integer('conduct_point');
            $table->integer('occurrence_number');
            $table->integer('counted_point');
            $table->text('action_notes');
            $table->string('photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_log_details');
    }
};
