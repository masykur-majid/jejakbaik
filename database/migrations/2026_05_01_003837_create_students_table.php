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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            //foreign to table user 
            //untuk fitur otomatis tambah user ketika ada siswa baru masuk
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('nisn')->unique()->nullable();
            $table->string('nis')->unique()->nullable();
            $table->string('student_name');
            $table->string('email')->unique();
            $table->string('current_grade')->default('10');

            //foreign to table classgroups
            $table->foreignId('class_group_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            //foreign to teachers table
            //untuk mendata guru wali untuk siswa ini
            $table->foreignId('teacher_id')
                  ->nullable()
                  ->onDelete('set null');
            $table->integer('current_point')->default(150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
