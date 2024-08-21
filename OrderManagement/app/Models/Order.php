<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable=['user_id', 'total_amount', 'discounted_amount','discount_amount', 'shipping_cost', 'applied_campaign', 'status'];

    public function user(){
        $this->belongsTo(User::class,'user_id');
    }
    public function items(){
        return $this->hasMany(OrderItem::class);
    }
}
