<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'category_id',
        'author_id',
        'list_price',
        'stock_quantity',
        'is_available'
    ];
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function author(){
        return $this->belongsTo(Author::class,'author_id');
    }
}
