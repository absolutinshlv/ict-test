<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $filliable = [
        'title',
        'body',
        'user_id',
    ];

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('body', 'like', "%$search%");
            });
        }

        return $query;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
