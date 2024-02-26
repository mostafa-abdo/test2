<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'state_id',
        'image',
        'views',
    ];

    protected $table = 'blogs';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function states ()
    {
        return $this->belongsTo(BlogState::class, 'state_id');
    }
}
