<?php

use App\Administrator;
use Illuminate\Database\Seeder;

class AdministratorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name'     => 'MLM Administrator',
            'email'    => 'admin@verumtrade.com',
            'password' => '123456',
        ];
        Administrator::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        dump($data);
    }
}
