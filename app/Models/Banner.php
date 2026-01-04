<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'image',
        'link_type',
        'link_slug',
        'custom_link',
        'is_active',
    ];

    protected $casts = [ // Memberi tahu Laravel bahwa kolom is_active adalah boolean.
        'is_active' => 'boolean',
    ];

    public function getUrlAttribute(): string // Method ini membuat property virtual bernama url -> contoh : $banner->url (/phones/10)
    {
        return match ($this->link_type) {
            'brand' => route('brands.show', $this->link_slug),
            'phone' => route('phones.show', $this->link_slug),
            'category' => route('categories.show', $this->link_slug),
            'custom' => $this->custom_link ?? '#',
            default => '#',
        };
    }

    /**
     * Scope banner aktif
     */

    public function scopeActive($query) // Membuat filter reusable. membuat kodingan lebih pendek
    {                                   // Banner::where('is_active', true)->get(); -> menjadi -> Banner::active()->get();
        return $query->where('is_active', true);
    }
}
