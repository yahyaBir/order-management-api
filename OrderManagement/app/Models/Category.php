<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable=[
        'category_title'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
