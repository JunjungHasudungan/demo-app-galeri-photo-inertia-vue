<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\{Post, Image, Chirp};
use App\Helpers\Category;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\Inertia;

class GaleriPhotoController extends Controller
{
    public function index() : Response
    {
        return Inertia::render('GaleriPhoto/Index', [
            'galeriPhoto'   => Post::with('user')->latest()->get(),
            'categories'    => Category::category,
            'chirps' => Chirp::with('user:id,name')->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
       $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string|max:225',
            'images' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'title.required' => 'Judul album wajib disi..',
            'category.required' => 'Kategori album wajib dipilih..',
            'description.required' => 'keterangan album wajib diisi..',
            'images.required' => 'Gambar album wajib diisi..',
        ]);

        $post = Post::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'category'      => $request->category,
            'slug'          => Str::slug($request->title),
            'user_id'       => Auth::user()->id
        ]);

        if ($request->images) {
            foreach ($request->file('images') as $file) {
                // Pastikan ada file yang diupload
                if ($file->isValid()) {

                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension(); // Ekstensi file

                    $uniqueFileName = $originalName . '_' . time() . '.' . $extension;

                    $path = $file->storeAs('images', $uniqueFileName, 'public');


                    Image::create([
                        'post_id' => $post->id,
                        'path' => $path
                    ]);
                }
            }
        }

        return redirect(route('galeri-photo.index'));
    }
}
