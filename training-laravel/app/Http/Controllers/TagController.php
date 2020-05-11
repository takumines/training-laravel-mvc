<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTagForm;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Tag $tag)
    {
        $tags = $tag->all();
        $posts = $tag->selectTag();

        return view('post.index', [
            'tags'  => $tags,
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTagForm $request, Tag $tag)
    {
        $tag->category = $request->category;
        $tag->save();

        return redirect('/post/create')->with('flash_message', 'タグを追加しました');
    }
}
