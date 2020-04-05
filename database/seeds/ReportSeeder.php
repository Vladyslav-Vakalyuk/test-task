<?php

use App\Report;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Report::truncate();

        $data = [
            ['product_id' => 1, 'ammount' => 300, 'purchased' => 3, 'created_at' => '2020-03-09 00:00:00', 'updated_at' => '2020-03-09 00:00:00'],
            ['product_id' => 2, 'ammount' => 100, 'purchased' => 1, 'created_at' => '2020-03-09 14:12:49', 'updated_at' => '2020-03-09 00:00:00'],
            ['product_id' => 1, 'ammount' => 400, 'purchased' => 4, 'created_at' => '2020-03-10 00:00:00', 'updated_at' => '2020-03-10 00:00:00'],
            ['product_id' => 1, 'ammount' => 700, 'purchased' => 7, 'created_at' => '2020-03-10 00:00:00', 'updated_at' => '2020-03-10 00:00:00'],
            ['product_id' => 2, 'ammount' => 400, 'purchased' => 2, 'created_at' => '2020-03-10 13:00:00', 'updated_at' => '2020-03-10 00:00:00'],
            ['product_id' => 2, 'ammount' => 800, 'purchased' => 4, 'created_at' => '2020-03-11 14:13:59', 'updated_at' => '2020-03-11 00:00:00']
        ];

        Report::insert($data);
    }
}
