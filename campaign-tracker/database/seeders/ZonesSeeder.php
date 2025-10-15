<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonesSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            ['zone_name' => 'Zone 1', 'zone_code' => 'Z1'],
            ['zone_name' => 'Zone 2', 'zone_code' => 'Z2'],
            ['zone_name' => 'Zone 3', 'zone_code' => 'Z3'],
            ['zone_name' => 'Zone 4', 'zone_code' => 'Z4'],
            ['zone_name' => 'Zone 5', 'zone_code' => 'Z5'],
            ['zone_name' => 'Zone 6', 'zone_code' => 'Z6'],
        ];
        DB::table('zones')->insert($zones);
    }
}
