<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create ()
    {
        $categories = Category::all();
        return view('post.create', ['categories' => $categories]);
    }

    public function show ($id) {
        $post = Post::findOrFail($id);

        return view('post.show', ['post' => $post]);
    }

    public function store (Request $request) {
        $request->validate([
            'title'             => 'required|min:4|max:255',
            'featured_image'    => 'required|url',
            'content'           => 'required|min:4',
            'category_id'       => 'required|numeric|exists:categories,id'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->featured_image = $request->featured_image;
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        $post->save();

        // $post = Post::create($request->all());

        return redirect("/posts/{$post->id}");
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('post.edit', ['post' => $post]);
    }

    public function update($id, Request $request)
    {
        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->featured_image = $request->featured_image;
        $post->content = $request->content;
        $post->save();

        return redirect("/posts/{$post->id}");
    }
}