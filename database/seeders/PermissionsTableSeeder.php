<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('database/data/permissions.csv'), 'r');
        $firstLine = true;
        while (($data = fgetcsv($csvFile, 1000, ',')) !== false) {
            if ($firstLine) {
                $firstLine = false;
                continue;
            }
            DB::table('permissions')->insert([
                'id' => $data[0],
                'permissionName' => $data[1],
                'description' => $data[2],
                'created_at' => $data[3],
                'updated_at' => $data[4],
            ]);
        }
        fclose($csvFile);
    }
}
