<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'address_id',
        'phone',
        'status',
        'payment_status',
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function details_order(){
        return $this->hasMany(DetailsOrder::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }
}
