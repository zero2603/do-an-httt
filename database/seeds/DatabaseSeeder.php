<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(User::class);
        $this->call(Product::class);
        $this->call(Category::class);
        $this->call(Attribute::class);
        $this->call(ProductImage::class);
    }
}
