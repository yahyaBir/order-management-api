<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('authors')->insert([
            [
                'name'=> 'Yaşar Kemal',
                'author_origin'=> 'local',
            ],
            [
                'name'=> 'Oğuz Atay',
                'author_origin'=> 'local',
            ],
            [
                'name'=> 'Sabahattin Ali',
                'author_origin'=> 'local',
            ],
            [
                'name'=> 'John Steinback',
                'author_origin'=> 'foreign',
            ],
            [
                'name'=> 'Jose Mauro De Vasconcelos',
                'author_origin'=> 'foreign',
            ],
            [
                'name'=> 'Hakan Mengüç',
                'author_origin'=> 'local',
            ],
            [
                'name'=> 'Stephen Hawking',
                'author_origin'=> 'foreign',
            ],
            [
                'name'=> 'Uğur Koşar',
                'author_origin'=> 'local',
            ],
            [
                'name'=> 'Mehmet Yıldız',
                'author_origin'=> 'local',
            ],
            [
                'name'=> 'Mert Arık',
                'author_origin'=> 'local',
            ],
        ]);
    }
}
