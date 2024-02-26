<?php

namespace App\Models;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogState extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $table = 'blogs_states';

    public function blog()
    {
        return $this->hasMany(Blog::class);
    }
}
