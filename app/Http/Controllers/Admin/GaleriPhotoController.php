<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Helpers\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\Inertia;

class GaleriPhotoController extends Controller
{
    public function index() : Response
    {
        return Inertia::render('GaleriPhoto/Index', [
            'galeriPhoto'   => Post::with('user')->latest()->get(),
            'categories'    => Category::category
        ]);
    }

    public function store(Request $request) 
    {
        dd($request);
        $validated = $request->validate([

        ]);

        Post::create($validated);
    }
}
