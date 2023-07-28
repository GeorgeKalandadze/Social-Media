<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'slug',
        'user_id',
        'subcategory_id'
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class,'subcategory_id');
    }

    public function postImages (): HasMany
    {
        return $this->hasMany(PostImage::class);
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites', 'post_id', 'user_id')->withTimestamps();
    }
}
