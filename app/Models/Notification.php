<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'notifiable_type',
        'notifiable_id',
        'author_id',
        'is_read',
    ];
}
