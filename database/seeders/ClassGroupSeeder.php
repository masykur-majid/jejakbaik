<?php

namespace Database\Seeders;

use App\Models\ClassGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classgroups = [
            ['class_name' => '2025-MP', 'code_of_vocation' => 'MP'],
            ['class_name' => '2024-MP', 'code_of_vocation' => 'MP'],
            ['class_name' => '2023-MP', 'code_of_vocation' => 'MP'],
            ['class_name' => '2025-RPL', 'code_of_vocation' => 'RPL'],
            ['class_name' => '2024-RPL', 'code_of_vocation' => 'RPL'],
            ['class_name' => '2023-RPL', 'code_of_vocation' => 'RPL'],
            
        ];

        foreach ($classgroups as $classgroup) {
            ClassGroup::create($classgroup);
        }
    }
}
