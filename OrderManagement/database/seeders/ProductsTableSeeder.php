<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'title' => 'İnce Memed',
                'category_id' => 1,
                'author_id'=> 1,
                'list_price' => 48.75,
                'stock_quantity' => 1000,
            ],
            [
                'title' => 'Tutunamayanlar',
                'category_id' => 1,
                'author_id'=> 2,
                'list_price' => 90.3,
                'stock_quantity' => 1000,
            ],
            [
                'title' => 'Kürk Mantolu Madonna',
                'category_id' => 1,
                'author_id'=> 3,
                'list_price' => 9.1,
                'stock_quantity' => 1000,
            ],
            [
                'title' => 'Fareler ve İnsanlar',
                'category_id' => 1,
                'author_id'=> 4,
                'list_price' => 35.75,
                'stock_quantity' => 1000,
            ],
            [
                'title' => 'Şeker Portakalı',
                'category_id' => 1,
                'author_id'=> 5,
                'list_price' => 33,
                'stock_quantity' => 1000,
            ],
            [
                'title' => 'Sen Yola Çık Yol Sana Görünür',
                'category_id' => 2,
                'author_id'=> 6,
                'list_price' => 28.5,
                'stock_quantity' => 1000,
            ],
            [
                'title' => 'Kara Delikler',
                'category_id' => 3,
                'author_id'=> 7,
                'list_price' => 39,
                'stock_quantity' => 1000,
            ],
            [
                'title' => 'Allah De Ötesini Bırak',
                'category_id' => 4,
                'author_id'=> 8,
                'list_price' => 39.6,
                'stock_quantity' => 1000,
            ],
            [
                'title' => 'Aşk 5 Vakittir',
                'category_id' => 4,
                'author_id'=> 9,
                'list_price' => 42,
                'stock_quantity' => 1000,
            ],
            [
                'title' => 'Benim Zürafam Uçabilir',
                'category_id' => 4,
                'author_id'=> 10,
                'list_price' => 27.3,
                'stock_quantity' => 1000,
            ],
        ]);
    }
}
