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
                'title' => 'Buy 2, Get 1 Free (Sabahattin Ali Roman)',
                'type' => 'b2g1_author_cat',
                'value' => null,
                'discount_threshold' => null,
                'category_id' => 1,
                'author_id' => 3,
                'author_origin_for_campaign' => null,
            ],
            [
                'title' => 'Buy 3, Get 1 Free in Selected Categories',
                'type' => 'b3g1_selected_cat',
                'value' => null,
                'discount_threshold' => null,
                'category_id' => 4,
                'author_id' => null,
                'author_origin_for_campaign' => null,
            ],
            [
                'title' => '5% Discount on Orders Over 200 TL',
                'type' => 'discount_for_amount',
                'value' => 5,
                'discount_threshold' => 200,
                'category_id' => null,
                'author_id' => null,
                'author_origin_for_campaign' => null,
            ],
            [
                'title' => '5% Discount for Local Authors',
                'type' => 'discount_for_author_origin',
                'value' => 5,
                'discount_threshold' => null,
                'category_id' => null,
                'author_id' => null,
                'author_origin_for_campaign' => 'local',
            ],
        ]);
    }
}
