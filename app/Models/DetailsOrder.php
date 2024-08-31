<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'product_title',
        'quantity',
        'price',
    ];
    
}
