<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $table = 'campaigns';
    protected $fillable = [
        'title',
        'type',
        'value',
        'discount_threshold',
        'category_id',
        'author_id',
        'author_origin_for_campaign',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
