<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['category_title' => 'Roman'],
            ['category_title' => 'Din'],
            ['category_title' => 'Bilim'],
            ['category_title' => 'Çocuk'],
        ]);
    }
}
