<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts'; 

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status',
        'user_id',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Quan hệ: bài viết thuộc về user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}