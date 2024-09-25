<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsCart extends Model
{
    use HasFactory;
    protected $fillable = [
        'cart_id',
        'product_id',
        'attribute',
        'quantity',
    ];
    
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
