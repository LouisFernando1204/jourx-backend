<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'content',
        'user_id',
        'ai_response',
        'emotion',
        'suggestions_ai',
        'quote',
        'stress_level',
        'is_processed'
    ];

    protected $casts = [
        'stress_level' => 'integer',
        'is_processed' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
