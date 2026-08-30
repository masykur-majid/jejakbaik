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
        Schema::table('point_log_details', function (Blueprint $table) {
            $table->foreignId('point_log_id')
                ->change() 
                ->constrained('point_logs')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('point_log_details', function (Blueprint $table) {
            $table->foreignId('point_log_id')
                ->change() 
                ->constrained('point_logs')
                ->cascadeOnDelete();
        });
    }
};
