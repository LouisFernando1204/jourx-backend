<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_published' => 'boolean',
        'views_count' => 'integer'
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            $article->slug = Str::slug($article->title);
        });

        static::saving(function ($article) {
            if ($article->image) {
                $article->image_url = asset('storage/' . $article->image);
            }
        });
    }
}
