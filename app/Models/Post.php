<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;

        if (!isset($this->attributes['slug']) || $this->attributes['title'] !== $value) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }
}
