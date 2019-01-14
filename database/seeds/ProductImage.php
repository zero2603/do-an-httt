<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImage extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        DB::table('product_images')->truncate();
        DB::table('product_category')->truncate();

        $products = \App\Product::all();
        $categories = \App\Category::all();

        $product_categories = [];
        $product_images = [];

        foreach($products as $key => $product) {
            array_push($product_images, [
                'product_id' => $product->id,
                'source' => $faker->imageUrl(),
            ], [
                'product_id' => $product->id,
                'source' => $faker->imageUrl(),
            ]);

            array_push($product_categories, [
                'product_id'=> $product->id,
                'category_id' => $key % count($categories) + 1
            ]);
        }
        DB::table('product_category')->insert($product_categories);
        DB::table('product_images')->insert($product_images);
    }
}
