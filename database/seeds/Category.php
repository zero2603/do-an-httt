<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Category extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        DB::table('categories')->truncate();

        $category_names = ['Áo sơ mi', 'Áo thu đông', 'Áo phông', 'Váy', 'Quần bò', 'Quần kaki'];
        $data = [];
        foreach($category_names as $name) {
            $category = [
                'name' => $name,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
            array_push($data, $category);
        }
        DB::table('categories')->insert($data);
    }
}
