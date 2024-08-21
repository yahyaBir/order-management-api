<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable= [
        'order_id',
        'product_id',
        'price',
        'quantity'
    ];
    public function order(){
        $this->belongsTo(Order::class,'order_id');
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
