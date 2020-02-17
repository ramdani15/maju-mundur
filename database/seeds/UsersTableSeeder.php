<?php

use Illuminate\Support\Facades\Hash;
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
        User::insert([
        	[
        		'name' => 'super',
        		'username' => 'super',
        		'email' => 'super@gmail.com',
        		'role' => 'super',
        		'password' => Hash::make(123),
        	],
        	[
        		'name' => 'merchant1',
        		'username' => 'merchant1',
        		'email' => 'merchant1@gmail.com',
        		'role' => 'merchant',
        		'password' => Hash::make(123),
        	],
        	[
        		'name' => 'merchant2',
        		'username' => 'merchant2',
        		'email' => 'merchant2@gmail.com',
        		'role' => 'merchant',
        		'password' => Hash::make(123),
        	],
        	[
        		'name' => 'customer1',
        		'username' => 'customer1',
        		'email' => 'customer1@gmail.com',
        		'role' => 'customer',
        		'password' => Hash::make(123),
        	],
        	[
        		'name' => 'customer2',
        		'username' => 'customer2',
        		'email' => 'customer2@gmail.com',
        		'role' => 'customer',
        		'password' => Hash::make(123),
        	],
        ]);
    }
}
