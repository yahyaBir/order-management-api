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
        DB::table('campaigns')->insert([
            [
                'title' => '2 al, 1 bedava (Sabahattin Ali Roman)',
                'type' => 'buy_one_get_one',
                'value' => null,
                'discount_threshold' => null,
                'category_id' => 1,
                'author_id' => 3,
            ],
            [
                'title' => '5% Discount on Orders Over 200 TL',
                'type' => 'discount',
                'value' => 5,
                'discount_threshold' => 200,
                'category_id' => null,
                'author_id' => null,
            ],
            [
                'title' => '5% Discount for Local Authors',
                'type' => 'discount',
                'value' => 5,
                'discount_threshold' => null,
                'category_id' => null,
                'author_id' => 2,
            ],
        ]);
    }
}
