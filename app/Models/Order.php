<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'order_code',
        'total_amount',
        'tax_amount',
        'shipping_address',
        'city',
        'post_code',
        'is_paid',
        'payment_proof',
    ];

    public static function generateUniqueOrdId()
    {
        $prefix = 'ORD';
        do {
            $randomString = $prefix . mt_rand(1000, 9999);
        } while (self::where('order_code', $randomString)->exists());

        return $randomString;
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
