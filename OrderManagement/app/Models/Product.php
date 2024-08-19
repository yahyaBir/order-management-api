<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'category_id',
        'product_title',
        'author',
        'list_price',
        'stock_quantity',
        'is_available'
    ];
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
