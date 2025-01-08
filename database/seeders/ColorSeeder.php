<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    public function run()
    {
        $colors = [
            ['name' => 'Green', 'hex_code' => '00FF00'],
            ['name' => 'Blue', 'hex_code' => '0000FF'],
            ['name' => 'Yellow', 'hex_code' => 'FFFF00'],
            ['name' => 'Orange', 'hex_code' => 'FFA500'],
            ['name' => 'Purple', 'hex_code' => '800080'],
            ['name' => 'White', 'hex_code' => 'FFFFFF'],
            ['name' => 'Black', 'hex_code' => '000000'],
        ];

        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}
