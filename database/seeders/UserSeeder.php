<?php

namespace Database\Seeders;

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
        DB::table('users')->delete();
        DB::table('users')->insert([
            'id' => 1,
            'role'=>2, 
            'first_name'=>'admin', 
            'email'=>'admin@gmail.com',
            'password'=>bcrypt('admin')
        ]);
    }
}
