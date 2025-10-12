<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';

    protected $fillable = [
        'external_id',
        'title',
        'description',
        'url',
        'source',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public $timestamps = true;
}
