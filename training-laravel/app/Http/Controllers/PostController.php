<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

        return view('post.index', [
            'posts' => $posts,
            'tags' => $tags,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Tag $tag)
    {
        $tags = $tag->all();
        return view('post.create', ['tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostForm $request, Post $post)
    {
        $post->user_id = Auth::id();
        $form = $request->all();
        $post->uploadImage($form);
        unset($form['image']);
        $post->fill($form)->save();
        $post->tags()->detach();
        $post->tags()->attach($request->tags);

        return redirect('/')->with('flash_message', '投稿しました');
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

        return view('post.show', [
            'post' => $post,
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post, Tag $tag)
    {
        $tags = $tag->all();
        $selectTags = $post->tags;

        return view('post.edit', [
            'post' => $post,
            'tags' => $tags,
            'selectTags' => $selectTags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $form = $request->all();
        $post->uploadImage($form);
        unset($form['image']);
        $post->fill($form)->save();
        $post->tags()->detach();
        $post->tags()->attach($request->tags);

        return redirect('/')->with('flash_message', '編集しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/')->with('flash_message', '投稿を削除しました');
    }
}
