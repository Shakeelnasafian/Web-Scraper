<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'title',
        'url',
        'description',
        'content',
        'url_to_image',
        'published_at',
        'category',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
