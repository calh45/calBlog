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
        //List of Category tags
        $listToMake = ["Comedy", "Advice", "Academic", "Outdoor", "Lifestyle"];

        //Create Category model for each Category tag
        foreach ($listToMake as $currentName) {
            $toAdd = new \App\Category();
            $toAdd->name = $currentName;
            $toAdd->save();
        }
    }
}
