<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Post $post, Tag $tag)
    {
        $tags = $tag->all();
        $posts = $post->postQuery($request);

        return response()->json([
            'message' => 'Admin post list',
            'data' => [
                $tags,
                $posts,
            ]
        ],200, [], JSON_UNESCAPED_UNICODE);
    }

    public function show($id, Tag $tag)
    {
        $post = Post::find($id);
        $tags = $post->tags;

        if ($post) {
            return response()->json([
                'message' => 'ok',
                'data' => [
                    $post,
                    'tag' => $tags
                ]
            ],200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json([
                'message' => 'Post not found'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post) {
            $post->delete();

            return response()->json([
                'message' => 'Post deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }
    }
}
