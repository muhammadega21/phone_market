<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhoneReview extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_name',
        'rating',
        'review',
        'photo',
        'photo_id',
    ];

    public function phone()
    {
        return $this->belongsTo(Phone::class, 'phone_id');
    }
}
