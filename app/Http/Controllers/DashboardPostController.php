<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Profil;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ImageProperty;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->is_admin){
            return view('dashboard.posts.index', [
                'profils' => Profil::latest()->get(),
                'posts' => Post::latest()->get(),
                'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
            ]);
        }
        return view('dashboard.posts.index', [
            'profils' => Profil::latest()->get(),
            'posts' => Post::where('user_id', auth()->user()->id)->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.posts.create', [
            'profils' => Profil::latest()->get(),
            'categories' => Category::all(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:posts',
            'category_id' => 'required',
            'image'=> 'image|file|max:2048',
            'body' => 'required'
        ]);

        if($request->has('published')){
            $validatedData['published'] = true;
        } else {
            $validatedData['published'] = false;
        }

        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('post-image');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

        Post::create($validatedData);

        return redirect('/dashboard/posts')->with('success', 'New Post has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('dashboard.posts.show', [
            'profils' => Profil::latest()->get(),
            'post' => $post,
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if(auth()->user()->is_admin){
            return view('dashboard.posts.edit', [
                'profils' => Profil::latest()->get(),
                'post' => $post,
                'categories' => Category::all(),
                'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
            ]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'image' => 'image|file|max:2048',
            'body' => 'required'
        ];

        if($request->slug != $post->slug) {
            $rules['slug'] = 'required|unique:posts';
        }

        $validatedData = $request->validate($rules);

        if($request->has('published')){
            $validatedData['published'] = true;
        } else {
            $validatedData['published'] = false;
        }

        if($request->file('image')) {
            if($post->image){
                Storage::delete($post->image);
            }
            $validatedData['image'] = $request->file('image')->store('post-image');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

        Post::where('id', $post->id)->update($validatedData);

        return redirect('/dashboard/posts')->with('success', 'Post has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if(auth()->user()->is_admin){
            if($post->image) {
                Storage::delete($post->image);
            }
            Post::destroy($post->id);

            return redirect('/dashboard/posts')->with('success', 'Post has been deleted!');
        } else {
            return redirect()->back();
        }
    }

    public function checkSlug(Request $request) {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);       
    }
}
