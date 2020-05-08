<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use App\Http\Requests\PostForm;

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

        return response([$tags, $posts],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostForm $request, Post $post)
    {
        $post->user_id = 1;

        $form = $request->all();
        $post->uploadImage($form);
        unset($form['image']);
        $post->fill($form)->save();
        $post->tags()->detach();
        $post->tags()->attach($request->tags);

        return response()->json([
            'message' => 'Post Created Successfully',
            'data' => $post
        ], 201, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $tags = $post->tags;
        if($post) {
            return response()->json([
                'message' => 'ok',
                'data' => [
                    $post,
                    'tag' => $tags
                ]
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostForm $request, $id)
    {
        $form = $request->all();
        $post = Post::find($id);
        $post->uploadImage($form);
        unset($form['image']);
        $post->fill($form)->save();
        $post->tags()->detach();
        $post->tags()->attach($request->tags);
        if($post) {
            return response()->json([
                'message' => 'Post updated Succsessfully',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
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
        $post = Post::find($id)->delete();
        if($post) {
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
