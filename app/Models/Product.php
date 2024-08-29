<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'images',
        'price',
        'quantity',
        'category_id',
    ];

    public function Category(){
        return $this->belongsTo(Category::class);
    }
}
