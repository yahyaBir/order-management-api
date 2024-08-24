<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $table = 'authors';
    protected $fillable=[
        'name',
        'author_origin',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
