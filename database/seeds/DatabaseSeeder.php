<?php

use Illuminate\Database\Seeder;
use App\Administrator;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        if (Administrator::all()->isEmpty()) {
            $this->call(AdministratorsTableSeeder::class);
        }
    }
}
