<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Mark;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insertData = json_decode(file_get_contents(base_path('database/seeders/countries.json')), true);
        $insertToMarks = [];
        foreach ($insertData as $datum){
            $insertToMarks[] = [
                'name' => $datum['country']
            ];
        }

        Country::query()->insert($insertToMarks);
    }
}
