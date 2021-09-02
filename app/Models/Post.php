<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int    id
 * @property string title
 * @property string content
 * @property mixed  comments
 */
class Post extends Model {

    use HasFactory;

    protected $guarded = [];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
