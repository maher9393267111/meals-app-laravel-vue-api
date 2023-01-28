<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Nutrient;


class NutrientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = fopen(base_path("database/data/nutrient.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, null, ",")) !== FALSE) {
            if (!$firstline) {
                Nutrient::create([
                    "category_id" => $data['1'],
                    "name" => $data['2'],
                    "carbs_in_hundred" => $data['6'],
                    "unit" => $data['7'],
                    "standard_amount" => $data['4'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
