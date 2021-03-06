<?php

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
        DB::table('users')->insert([
            'full_name' => 'Nguoi quan tri',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'is_admin' => true,
        ]);
        
        DB::table('users')->insert([
            'full_name' => 'Khach mua hang',
            'email' => 'guest@gmail.com',
            'password' => bcrypt('123456'),
            'is_admin' => false,
        ]);
    }
}
