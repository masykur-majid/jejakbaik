<?php

namespace Database\Seeders;

use App\Models\Vocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vocations = [
            ['vocation_code'=>'MP', 'vocation_name'=>'Manajemen Perkantoran'],
            ['vocation_code'=>'RPL', 'vocation_name'=>'Rekayasa Perangkat Lunak']
        ];

        foreach ($vocations as $vocation) {
            Vocation::create($vocation);
        }
    }
}
