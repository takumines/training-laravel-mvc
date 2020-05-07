<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tag;

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

        return view('admin.post.index', [
            'tags'  => $tags,
            'posts' => $posts,
        ]);
    }

    /**
     * タグ削除
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect('/admin/')->with('flash_message', 'タグを削除しました');
    }
}
