<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'photo',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    public function pupulasPhones()
    {
        return $this->hasMany(Phone::class)->where('is_featured', true)->orderBy('created_at', 'desc');
    }
}
