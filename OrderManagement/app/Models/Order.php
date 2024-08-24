<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable=['user_id','order_amount', 'total_amount', 'shipping_cost', 'applied_campaign', 'status'];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function user(){
        $this->belongsTo(User::class,'user_id');
    }
    public function items(){
        return $this->hasMany(OrderItem::class);
    }
}
