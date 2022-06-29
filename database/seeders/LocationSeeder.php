<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['Duhok', 1, 1, 0],
            ['Duhok (Guesthouse #1)', 1, 1, 1],
            ['Duhok (Guesthouse #2)', 1, 1, 1],
            ['Duhok (Khani Hotel)', 1, 1, 1],
            ['Duhok (Dunya Hotel)', 1, 1, 1],
            ['Duhok (Jiyan Hotel)', 1, 1, 1],
            ['Erbil', 1, 1, 0],
            ['Erbil (Fiori Hotel)', 1, 1, 1],
            ['Erbil (Ankawa Royal  Hotel)', 1, 1, 1],
            ['Baghdad', 0, 1, 0],
            ['Baghdad (Coral Baghdad Hotel)', 0, 1, 1],
            ['Mosul', 0, 1, 0],
            ['Sinuni', 0, 1, 0],
            ['Sinuni (Consortium Guesthouse)', 0, 1, 1],
            ['Tal Afar', 0, 1, 0],
            ['Sinjar', 0, 1, 0],
            ['Sinjar (Sinjar Office Guesthouse)', 0, 1, 1],
        ];

        foreach ($data as $datum) {
            Location::insert([
                'name' => $datum[0],
                'is_krg' => $datum[1],
                'is_available' => $datum[2],
                'is_accommodation' => $datum[3],
                'created_at' => now(),
            ]);
        }
    }
}
