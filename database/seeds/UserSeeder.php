<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $data = [
            ['name' => 'User_0', 'email' => 'User_0@mail.com', 'password' => Hash::make('12345678'), 'api_token' => bin2hex(openssl_random_pseudo_bytes(30))],
            ['name' => 'User_1', 'email' => 'User_1@mail.com', 'password' => Hash::make('12345678'), 'api_token' => bin2hex(openssl_random_pseudo_bytes(30))],
            ['name' => 'User_2', 'email' => 'User_2@mail.com', 'password' => Hash::make('12345678'), 'api_token' => bin2hex(openssl_random_pseudo_bytes(30))],
            ['name' => 'User_3', 'email' => 'User_3@mail.com', 'password' => Hash::make('12345678'), 'api_token' => bin2hex(openssl_random_pseudo_bytes(30))]
        ];

        User::insert($data);
    }
}
