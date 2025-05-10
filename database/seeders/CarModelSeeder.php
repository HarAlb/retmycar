<?php

namespace Database\Seeders;

use App\Models\Mark;
use App\Models\CarModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insertData = json_decode(file_get_contents(base_path('database/seeders/marks.json')), true);
        $marks = Mark::query()->get();
        $insertIntoModels = [];

        foreach ($insertData as $datum){
            $makId = $marks->filter(fn ($mark) => $mark->name === $datum['brand'])->first()->id;
            foreach ($datum['models'] as $item){
                $insertIntoModels[] = [
                    'mark_id' => $makId,
                    'name' => $item
                ];
            }
        }
        CarModel::query()->insert($insertIntoModels);
    }
}
