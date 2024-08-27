<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 5; // Nombre de posts par page
        $posts = Post::with('user')->latest()->paginate($perPage);
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validatedData = $request->validated();

        $post = new Post();
        $post->content = $validatedData['content'];
        $post->tags = $validatedData['tags'];
        $post->user_id = Auth::id();

        $post->save();

        return response()->json([
            'status' => true,
            'message' => 'Post créé avec succès',
            'post' => $post
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::with('user')->find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json(['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //$this->authorize('update', $post);
        $validatedData = $request->validated();

        $post->content = $validatedData['content'];
        $post->tags = $validatedData['tags'];
        $post->save();

        return response()->json([
            'status' => true,
            'message' => 'Post mis à jour avec succès',
            'post' => $post
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'status' => true,
            'message' => 'Post supprimé avec succès'
        ]);
    }
}
