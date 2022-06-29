<?php

namespace Database\Seeders;

use App\Models\FundCode;
use Illuminate\Database\Seeder;

class FundCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 'AU240'],
            [2, 'AU241'],
            [3, 'CA683'],
            [4, 'CZ108'],
            [5, 'CZ109'],
            [6, 'CZ110'],
            [7, 'CZ124'],
            [8, 'CZ126'],
            [9, 'DE770'],
            [10, 'DE908'],
            [11, 'DE904'],
            [12, 'DE916'],
            [13, 'DE918'],
            [14, 'DE920'],
            [15, 'DE809'],
            [16, 'DE928'],
            [17, 'DE812'],
            [18, 'DE950'],
            [19, 'DE958'],
            [20, 'DE961'],
            [21, 'DE969'],
            [22, 'DE975'],
            [23, 'DEA07'],
            [24, 'DEA08'],
            [25, 'DEA14'],
            [26, 'DEA19'],
            [27, 'GB766'],
            [28, 'NO188'],
            [29, 'US000'],
            [30, 'US1UL'],
            [31, 'USL49'],
            [32, 'US2LQ'],
            [33, 'US2VN'],
            [34, 'US30A'],
            [35, 'US2KA'],
            [36, 'US3EH'],
        ];

        foreach ($data as $datum) {
            FundCode::insert([
                'id' => $datum[0],
                'name' => $datum[1],
                'description' => null,
                'created_at' => now(),
            ]);
        }
    }
}
