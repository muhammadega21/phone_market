<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhonePhoto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'photo',
        'photo_id',
    ];
}
