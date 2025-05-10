<?php

namespace Database\Seeders;

use App\Models\CarModel;
use App\Models\City;
use App\Models\Country;
use App\Models\Mark;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insertData = json_decode(file_get_contents(base_path('database/seeders/countries.json')), true);
        $marks = Country::query()->get();
        $insertIntoModels = [];

        foreach ($insertData as $datum){
            $makId = $marks->filter(fn ($mark) => $mark->name === $datum['country'])->first()->id;
            foreach ($datum['cities'] as $item){
                $insertIntoModels[] = [
                    'country_id' => $makId,
                    'name' => $item
                ];
            }
        }
        City::query()->insert($insertIntoModels);
    }
}
