<?php

use App\Models\CarModel;
use App\Models\City;
use App\Models\Country;
use App\Models\Mark;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!User::query()->where('email', 'example@gmail.com')->value('id')) {
            User::query()->create([
                'name' => 'test Account',
                'email' => 'example@gmail.com',
                'password' => Hash::make('password'),
                'email_verified_at' => date('Y-m-d H:i:s')
            ]);
        }

        $insertData = json_decode(file_get_contents(base_path('database/seeders/marks.json')), true);
        $insertToMarks = [];
        foreach ($insertData as $datum){
            $insertToMarks[] = [
                'name' => $datum['brand']
            ];
        }

        Mark::query()->insert($insertToMarks);

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

        $insertData = json_decode(file_get_contents(base_path('database/seeders/countries.json')), true);
        $insertToMarks = [];
        foreach ($insertData as $datum){
            $insertToMarks[] = [
                'name' => $datum['country']
            ];
        }

        Country::query()->insert($insertToMarks);

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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::table('users')->truncate();
        \Illuminate\Support\Facades\DB::table('car_models')->truncate();
        \Illuminate\Support\Facades\DB::table('marks')->truncate();
        \Illuminate\Support\Facades\DB::table('cities')->truncate();
        \Illuminate\Support\Facades\DB::table('countries')->truncate();
    }
};
