<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = fopen(base_path("database/data/category.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, null, ",")) !== FALSE) {
            if (!$firstline) {
                Category::create([
                    "id" => $data['0'],
                    "name" => $data['1'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
