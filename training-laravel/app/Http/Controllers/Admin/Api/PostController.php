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
}
