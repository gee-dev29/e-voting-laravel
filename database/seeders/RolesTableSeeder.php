<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $csvFile = fopen(base_path('database/data/roles.csv'), 'r');
        $firstLine = true;
        while (($data = fgetcsv($csvFile, 1000, ',')) !== false) {
            if ($firstLine) {
                $firstLine = false;
                continue;
            }
            DB::table('role')->insert([
                'id' => $data[0],
                'roleName' => $data[1],
                'created_at' => $data[2],
                'updated_at' => $data[3],
            ]);
        }
        fclose($csvFile);
    }
}
