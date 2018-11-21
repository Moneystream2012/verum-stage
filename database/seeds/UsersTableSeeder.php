<?php

use App\Events\Users\Registered;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = User::generateID();
        $id = 2;
        $data = [
            'id'                   => $id,
            'username'             => $id,
            'sponsor_id'           => 0,
            'email'                => $id.'@verumtrade.com',
            'mobile_number'        => '0999999'.random_int(000, 999),
            'password'             => '123456',
            'transaction_password' => '123456',
            'leg'                  => 1,
            'first_name'           => 'Verum',
            'last_name'            => 'Trade',
            'country'              => 'EN',
            'side_leg'             => false,
            'balance'              => 1000,
        ];
        $user = User::createUser($data);
        event(new Registered($user, $user->toArray() + $data));
        dump($user->toArray());
    }
}
