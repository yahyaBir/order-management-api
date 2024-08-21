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
                'list_price' => 48.75,
                'stock_quantity' => 10,
            ],
            [
                'product_title' => 'Tutunamayanlar',
                'category_id' => 1,
                'author' => 'Oğuz Atay',
                'list_price' => 90.3,
                'stock_quantity' => 20,
            ],
            [
                'product_title' => 'Kürk Mantolu Madonna',
                'category_id' => 1,
                'author' => 'Sabahattin Ali',
                'list_price' => 9.1,
                'stock_quantity' => 4,
            ],
            [
                'product_title' => 'Fareler ve İnsanlar',
                'category_id' => 1,
                'author' => 'John Steinback',
                'list_price' => 35.75,
                'stock_quantity' => 8,
            ],
            [
                'product_title' => 'Şeker Portakalı',
                'category_id' => 1,
                'author' => 'Jose Mauro De Vasconcelos',
                'list_price' => 33,
                'stock_quantity' => 1,
            ],
            [
                'product_title' => 'Sen Yola Çık Yol Sana Görünür',
                'category_id' => 2,
                'author' => 'Hakan Mengüç',
                'list_price' => 28.5,
                'stock_quantity' => 7,
            ],
            [
                'product_title' => 'Kara Delikler',
                'category_id' => 3,
                'author' => 'Stephen Hawking',
                'list_price' => 39,
                'stock_quantity' => 2,
            ],
            [
                'product_title' => 'Allah De Ötesini Bırak',
                'category_id' => 4,
                'author' => 'Uğur Koşar',
                'list_price' => 39.6,
                'stock_quantity' => 18,
            ],
            [
                'product_title' => 'Aşk 5 Vakittir',
                'category_id' => 4,
                'author' => 'Mehmet Yıldız',
                'list_price' => 42,
                'stock_quantity' => 9,
            ],
            [
                'product_title' => 'Benim Zürafam Uçabilir',
                'category_id' => 4,
                'author' => 'Mert Arık',
                'list_price' => 27.3,
                'stock_quantity' => 12,
            ],
        ]);
    }
}
