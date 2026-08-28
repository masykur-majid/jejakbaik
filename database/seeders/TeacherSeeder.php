<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            ['teacher_name' => 'Rizal Nugraha', 'email' => 'rizal.guru@jejak.web.id'],
            ['teacher_name' => 'Bayu Prasetyo', 'email' => 'bayu.guru@jejak.web.id'] 
        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }
    }
}
