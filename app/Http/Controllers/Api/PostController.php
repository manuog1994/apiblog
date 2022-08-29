<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::included()
                            ->filter()
                            ->sort()
                            ->getOrPaginate();
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:posts',
            'extract' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id', // no es necesario si esta logueado
        ]);


        $post = Post::create($data);

        return PostResource::make($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::included()->findOrFail($id);
        // retornamos el objeto según este definida en CategoryResource
        return PostResource::make($post);
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

        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:posts, slug,' . $post->id,
            'extract' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // actualizamos la información
        $post->update($request->all());

        // retornamos la información actualizada
        return PostResource::make($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        $post->delete();

        return PostResource::make($post);
    }
}
