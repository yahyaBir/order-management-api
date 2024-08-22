<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $table = 'campaigns';
    protected $fillable = [
        'name',
        'type',
        'value',
        'discount_threshold',
        'category_id',
    ];
}
