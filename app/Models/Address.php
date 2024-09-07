<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'phone',
        'address',
    ];

}
