<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listToMake = ["Comedy", "Advice", "Academic", "Outdoor", "Lifestyle"];

        foreach ($listToMake as $currentName) {
            $toAdd = new \App\Category();
            $toAdd->name = $currentName;
            $toAdd->save();
        }
    }
}
