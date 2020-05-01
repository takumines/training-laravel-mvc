<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Tag;
use App\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        return view('admin.post.index', [
            'posts' => $posts,
            'tags' => $tags,
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, Tag $tag)
    {
        $tags = $post->tags;

        return view('admin.post.show', [
            'post' => $post,
            'tags' => $tags
        ]);
    }
}
