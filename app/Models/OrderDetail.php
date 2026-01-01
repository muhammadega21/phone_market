<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'phone_id',
        'order_id',
        'price',
        'quantity',
    ];

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function phone()
    {
        return $this->belongsTo(Phone::class, 'phone_id');
    }
}
