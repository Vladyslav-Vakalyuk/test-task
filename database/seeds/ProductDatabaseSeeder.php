<?php

use Illuminate\Database\Seeder;
use App\Products;

class ProductDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Products::truncate();

        $data=[
            ['title' => 'Producr 1'],
            ['title' => 'Product 2'],
            ['title' => 'Product 3']
        ];

        Products::insert($data);

    }
}
