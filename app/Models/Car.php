<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'category_id',
        'color',
        'persons',
        'bags',
    ];

    protected $table = 'cars';


    public function category()
    {
        return $this->belongsTo(CarCategory::class);
    }
}
