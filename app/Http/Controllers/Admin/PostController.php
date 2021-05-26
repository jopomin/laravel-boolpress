<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'posts' => Post::all()
        ];

        return view('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $data = [
           'tags' => Tag::all()
       ];
       return view('admin.posts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titolo' => 'required|max:255',
            'contenuto' => 'required'
        ]);
        $form_data = $request->all();
        $new_post = new Post ();
        $new_post->fill($form_data);
        $slug = Str::slug($new_post->titolo);
        $slug_base = $slug;

        $post_esiste = Post::where('slug', $slug)->first();
        $cont = 1;
        while($post_esiste) {
            $slug = $slug_base . '-' . $cont;
            $cont++;
            $post_esiste = Post::where('slug', $slug)->first();
        }

        $new_post->slug = $slug;
        $new_post->user_id = Auth::id();

        $new_post->save();

        if (array_key_exists('tags', $form_data)) {
            $new_post->tags()->sync($form_data['tags']);
        }

        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id) {
            $post = Post::find($id);
            $data = [
                'post' => $post
            ];
            return view('admin.posts.show', $data);
        }
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (!$post) {
            abort(404);
        }

        $data = [
            'post' => $post,
            'tags' => Tag::all(),
            'categories' => Category::all()
        ];

        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'titolo' => 'required|max:255',
            'contenuto' => 'required'
        ]);

        $form_data = $request->all();

        if($form_data['titolo'] != $post->titolo) {
            $slug = Str::slug($form_data->titolo);
            $slug_base = $slug;
            $post_esiste = Post::where('slug', $slug)->first();
            $cont = 1;
            while($post_esiste) {
                $slug = $slug_base . '-' . $cont;
                $cont++;
                $post_esiste = Post::where('slug', $slug)->first();
            }

            $form_data['slug'] = $slug;

        }

        $post->update($form_data);

        if (array_key_exists('tags', $form_data)) {
            $post->tags()->sync($form_data['tags']);
        }

        else {
            $post->tags()->sync([]); 
        }

        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->tags()->sync([]);
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
