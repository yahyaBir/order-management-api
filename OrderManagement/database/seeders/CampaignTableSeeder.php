<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampaignTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*DB::table('campaigns')->insert([
            [
                'product_title' => 'İnce Memed',
                'category_id' => 1,
                'author' => 'Yaşar Kemal',
                'author_origin'=> 'local',
                'list_price' => 48.75,
                'stock_quantity' => 10,
            ],
            [
                'product_title' => 'İnce Memed',
                'category_id' => 1,
                'author' => 'Yaşar Kemal',
                'author_origin'=> 'local',
                'list_price' => 48.75,
                'stock_quantity' => 10,
            ]
        ]);*/
    }
}
