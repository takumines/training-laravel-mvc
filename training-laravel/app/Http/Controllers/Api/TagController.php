<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTagForm;
use App\Tag;

class TagController extends Controller
{
    public function index($id, Tag $tag)
    {
        $tags = $tag->all();
        $select_tag = Tag::find($id);
        $posts = $select_tag->selectTag();

        if (count($posts) > 0) {
            return response()->json([
                'message' => 'ok',
                'data' => [
                    $tags,
                    $posts,
                ]
                ], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }
    }

    public function store(CreateTagForm $request, Tag $tag)
    {
        $tag->category = $request->category;
        $tag->save();

        return response()->json([
            'message' => 'Tag Created Successfully',
            'data' => $tag
        ], 201, [], JSON_UNESCAPED_UNICODE);
    }
}
