<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Joel Mnisi',
            'email' => 'mnisij64@gmail.com',
            'password'=> bcrypt('password')
        ]);

    }
}
