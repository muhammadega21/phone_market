<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
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

        return Inertia::render('home/index', [
            'banners' => $banners,
            'categories' => $categories
        ]);
    }
}
