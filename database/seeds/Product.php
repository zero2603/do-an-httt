<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Product extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        DB::table('products')->truncate();

        $data = [];
        for($i=0; $i<20; $i++) {
            $product = [
                'product_name' => $faker->text(30),
                'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
                'discount' => $faker->randomElement(['0', '10%', '20%']),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
            array_push($data, $product);
        }
        DB::table('products')->insert($data);
    }
}
