<?php
// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
    ];

    // Define the relationship with Post
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
