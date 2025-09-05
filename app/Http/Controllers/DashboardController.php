<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'users'      => User::count(),
            'blogs'      => Blog::count(),
            'categories' => Category::count(),
            'tags'       => Tag::count(),
        ];

        return view('dashboard', compact('counts'));
    }
}
