<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class modelprototype extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modelpro')->insert([
            [
                'model_name' => 'Model A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'model_name' => 'Model B',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'model_name' => 'Model C',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
