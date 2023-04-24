<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Blog;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'blog_id',
        'body'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function blog(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
