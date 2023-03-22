<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
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
          'email' => 'admin@gmail.com',
          'firstname' => 'Muhamad',
          'lastname' => 'Reza ',
          'fullname' => 'Muhamad Reza',
          'password' => Hash::make('admin123'),
          'address' => 'Jl. Bkt No. 60',
          'level' => 'admin',
          'gender' => 'Laki-Laki',
          'telephone' => '088224811062'
        ]);
    }
}
