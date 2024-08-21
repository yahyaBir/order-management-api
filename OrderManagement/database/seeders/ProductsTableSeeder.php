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
                'product_title' => 'İnce Memed',
                'category_id' => 1,
                'author' => 'Yaşar Kemal',
                'author_origin'=> 'local',
                'list_price' => 48.75,
                'stock_quantity' => 1000,
            ],
            [
                'product_title' => 'Tutunamayanlar',
                'category_id' => 1,
                'author' => 'Oğuz Atay',
                'author_origin'=> 'local',
                'list_price' => 90.3,
                'stock_quantity' => 1000,
            ],
            [
                'product_title' => 'Kürk Mantolu Madonna',
                'category_id' => 1,
                'author' => 'Sabahattin Ali',
                'author_origin'=> 'local',
                'list_price' => 9.1,
                'stock_quantity' => 1000,
            ],
            [
                'product_title' => 'Fareler ve İnsanlar',
                'category_id' => 1,
                'author' => 'John Steinback',
                'author_origin'=> 'foreign',
                'list_price' => 35.75,
                'stock_quantity' => 1000,
            ],
            [
                'product_title' => 'Şeker Portakalı',
                'category_id' => 1,
                'author' => 'Jose Mauro De Vasconcelos',
                'author_origin'=> 'foreign',
                'list_price' => 33,
                'stock_quantity' => 1000,
            ],
            [
                'product_title' => 'Sen Yola Çık Yol Sana Görünür',
                'category_id' => 2,
                'author' => 'Hakan Mengüç',
                'author_origin'=> 'local',
                'list_price' => 28.5,
                'stock_quantity' => 1000,
            ],
            [
                'product_title' => 'Kara Delikler',
                'category_id' => 3,
                'author' => 'Stephen Hawking',
                'author_origin'=> 'foreign',
                'list_price' => 39,
                'stock_quantity' => 1000,
            ],
            [
                'product_title' => 'Allah De Ötesini Bırak',
                'category_id' => 4,
                'author' => 'Uğur Koşar',
                'author_origin'=> 'local',
                'list_price' => 39.6,
                'stock_quantity' => 1000,
            ],
            [
                'product_title' => 'Aşk 5 Vakittir',
                'category_id' => 4,
                'author' => 'Mehmet Yıldız',
                'author_origin'=> 'local',
                'list_price' => 42,
                'stock_quantity' => 1000,
            ],
            [
                'product_title' => 'Benim Zürafam Uçabilir',
                'category_id' => 4,
                'author' => 'Mert Arık',
                'author_origin'=> 'local',
                'list_price' => 27.3,
                'stock_quantity' => 1000,
            ],
        ]);
    }
}
