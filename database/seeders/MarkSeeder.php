<?php

namespace Database\Seeders;

use App\Models\Mark;
use Illuminate\Database\Seeder;

class MarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insertData = json_decode(file_get_contents(base_path('database/seeders/marks.json')), true);
        $insertToMarks = [];
        foreach ($insertData as $datum){
            $insertToMarks[] = [
                'name' => $datum['brand']
            ];
        }

        Mark::query()->insert($insertToMarks);
    }
}
