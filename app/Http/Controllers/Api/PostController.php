<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return response()->json([
            'data'    => PostResource::collection($posts),
            'message' => 'Fetch all posts',
            'success' => true,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'   => 'required|string|max:155',
            'content' => 'required',
            'status'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'    => [],
                'message' => $validator->errors(),
                'success' => false,
            ]);
        }

        $post = Post::create([
            'title'   => $request->get('title'),
            'content' => $request->get('content'),
            'status'  => $request->get('status'),
            'slug'    => Str::slug($request->get('title')),
        ]);

        return response()->json([
            'data'    => new PostResource($post),
            'message' => 'Post created successfully.',
            'success' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Post $post)
    {
        return response()->json([
            'data'    => new PostResource($post),
            'message' => 'Data post found',
            'success' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title'   => 'required|string|max:155',
            'content' => 'required',
            'status'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'    => [],
                'message' => $validator->errors(),
                'success' => false,
            ]);
        }

        $post->update([
            'title'   => $request->get('title'),
            'content' => $request->get('content'),
            'status'  => $request->get('status'),
            'slug'    => Str::slug($request->get('title')),
        ]);

        return response()->json([
            'data'    => new PostResource($post),
            'message' => 'Post updated successfully',
            'success' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'data'    => [],
            'message' => 'Post deleted successfully',
            'success' => true,
        ]);
    }
}
