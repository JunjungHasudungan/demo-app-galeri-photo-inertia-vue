<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class GaleriPhotoController extends Controller
{
    public function index() : Response
    {
        return Inertia::render('GaleriPhoto/Index', [
            'galeriPhoto' => Post::with('user:id,name')->latest()->get(),
        ]);
    }
}
