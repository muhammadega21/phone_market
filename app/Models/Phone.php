<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Phone extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'description',
        'category_id',
        'brand_id',
        'price',
        'stock',
        'is_featured',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function scopePopular($query)
    {
        return $query
            // ->whereHas('reviews')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_count');
    }

    public function specifications()
    {
        return $this->hasMany(PhoneSpecification::class);
    }

    public function photos()
    {
        return $this->hasMany(PhonePhoto::class);
    }

    public function reviews()
    {
        return $this->hasMany(PhoneReview::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
