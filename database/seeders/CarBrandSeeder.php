<?php

namespace Database\Seeders;

use App\Models\CarBrand;
use Illuminate\Database\Seeder;

class CarBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['Acura'],
            ['Alfa Romeo'],
            ['Audi'],
            ['BMW'],
            ['Bentley'],
            ['Buick'],
            ['Cadillac'],
            ['Chevrolet'],
            ['Chrysler'],
            ['Dodge'],
            ['Fiat'],
            ['Ford'],
            ['GMC'],
            ['Genesis'],
            ['Honda'],
            ['Hyundai'],
            ['Infiniti'],
            ['Jaguar'],
            ['Jeep'],
            ['Kia'],
            ['Land Rover'],
            ['Lexus'],
            ['Lincoln'],
            ['Lotus'],
            ['Lucid'],
            ['Maserati'],
            ['Mazda'],
            ['Mercedes'],
            ['Mercury'],
            ['Mini'],
            ['Mitsubishi'],
            ['Nissan'],
            ['Polestar'],
            ['Pontiac'],
            ['Porsche'],
            ['Ram'],
            ['Rivian'],
            ['Rolls-Royce'],
            ['Saab'],
            ['Saturn'],
            ['Scion'],
            ['Smart'],
            ['Subaru'],
            ['Suzuki'],
            ['Tesla'],
            ['Toyota'],
            ['Volkswagen'],
            ['Volvo'],
        ];

        foreach ($data as $datum) {
            CarBrand::insert([
                'name' => $datum[0],
                'created_at' => now(),
            ]);
        }
    }
}
