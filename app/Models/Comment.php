<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Overtrue\LaravelVote\Traits\Votable;

class Comment extends Model
{
    use HasFactory, Votable;

    protected $fillable = [
        'user_id',
        'post_id',
        'parent_comment_id',
        'body',
        'votes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return BelongsTo
     */
    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }


    public function childCommentsRecursive()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id')->with('childCommentsRecursive');
    }
}
