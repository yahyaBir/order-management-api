<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'userv1',
                'email' => 'userv1@gmail.com',
                'password' => Hash::make('12345678'),
                'is_admin' => '1',
            ],
            [
                'name' => 'userv2',
                'email' => 'userv2@gmail.com',
                'password' => Hash::make('12345678'),
                'is_admin' => '0',
            ],
            [
                'name' => 'userv3',
                'email' => 'userv3@gmail.com',
                'password' => Hash::make('12345678'),
                'is_admin' => '0',
            ],
        ]);
    }
}
