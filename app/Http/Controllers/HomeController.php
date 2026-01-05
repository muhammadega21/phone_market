<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Phone;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->get()->map(function ($banner) {
            return [
                'id' => $banner->id,
                'image' => $banner->image,
                'url' => $banner->url,
            ];
        });;

        $categories = Category::get();
        $featuredPhones = Phone::with(['category', 'brand', 'specifications'])->where('is_featured', true)->take(6)->get();
        $popularPhones = Phone::with(['category', 'brand', 'specifications', 'reviews'])->popular()->take(6)->get();

        return Inertia::render('home/index', [
            'banners' => $banners,
            'categories' => $categories,
            'featuredPhones' => $featuredPhones,
            'popularPhones' => $popularPhones
        ]);
    }
}
