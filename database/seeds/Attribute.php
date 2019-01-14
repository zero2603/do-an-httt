<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Attribute extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        DB::table('colors')->truncate();
        DB::table('sizes')->truncate();
        DB::table('stock')->truncate();
        // color
        $color_names = ['Xanh lá cây', 'Đỏ', 'Xanh dương', 'Vàng', 'Đen', 'Trắng', 'Nâu'];
        $color_data = [];
        foreach($color_names as $name) {
            $color = [
                'name' => $name,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
            array_push($color_data, $color);
        }
        DB::table('colors')->insert($color_data);
        // size
        $size_names = ['S', 'M', 'L', 'XL', 'XXL'];
        $size_data = [];
        foreach($size_names as $name) {
            $size = [
                'name' => $name,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
            array_push($size_data, $size);
        }
        DB::table('sizes')->insert($size_data);
        //  stock
        $products = \App\Product::all();
        $colors = \App\Color::all();
        $sizes = \App\Size::all();
        $stocks = [];
        
        foreach($products as $key => $product) {
            array_push($stocks, [
                'product_id' => $product->id,
                'color_id' => $key % count($colors) + 1,
                'size_id' => $key % count($sizes) + 1,
                'buying_price' => $faker->numberBetween(50000, 10000),
                'selling_price' => $faker->numberBetween(50000, 10000),  
            ]);
        }

        DB::table('stock')->insert($stocks);
    }
}
