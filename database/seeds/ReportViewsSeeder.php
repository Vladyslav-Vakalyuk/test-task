<?php

use App\ReportViews;
use Illuminate\Database\Seeder;

class ReportViewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReportViews::truncate();

        $data = [
            ['product_id' => 1, 'total_views' => 45, 'user_id' => 2, 'created_at' => '2020-03-15 15:29:27', 'updated_at' => '2020-03-09 00:00:00'],
            ['product_id' => 1, 'total_views' => 88, 'user_id' => 3, 'created_at' => '2020-03-09 00:00:00', 'updated_at' => '2020-03-09 00:00:00'],
            ['product_id' => 1, 'total_views' => 53, 'user_id' => 4, 'created_at' => '2020-03-09 00:00:00', 'updated_at' => '2020-03-09 00:00:00'],
            ['product_id' => 2, 'total_views' => 77, 'user_id' => 2, 'created_at' => '2020-03-15 15:29:29', 'updated_at' => '2020-03-09 00:00:00'],
            ['product_id' => 1, 'total_views' => 99, 'user_id' => 2, 'created_at' => '2020-03-10 00:00:00', 'updated_at' => '2020-03-10 00:00:00'],
            ['product_id' => 1, 'total_views' => 74, 'user_id' => 3, 'created_at' => '2020-03-10 00:00:00', 'updated_at' => '2020-03-10 00:00:00'],
            ['product_id' => 1, 'total_views' => 756, 'user_id' => 4, 'created_at' => '2020-03-10 00:00:00', 'updated_at' => '2020-03-10 00:00:00'],
            ['product_id' => 2, 'total_views' => 123, 'user_id' => 2, 'created_at' => '2020-03-10 00:00:00', 'updated_at' => '2020-03-10 00:00:00'],
            ['product_id' => 2, 'total_views' => 237, 'user_id' => 2, 'created_at' => '2020-03-15 15:31:01', 'updated_at' => '2020-03-11 00:00:00']
        ];

        ReportViews::insert($data);
    }
}
