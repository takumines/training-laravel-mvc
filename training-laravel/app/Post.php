<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'body', 'image'];

    /**
     * usersテーブルとのリレーション
     * @return $obj
     */
    public function user()
    {
        return $this->belongsTo('App\user');
    }

    /**
     * 検索結果の記事または全ての記事を返す
     * @param $posts
     */
    public function postQuery($request)
    {
        if ($request->type === 'title') {
            $posts = Post::where('title', 'like', '%'.$request->keyword.'%')->orderBy('created_at','desc')->paginate(4);
        }
        if ($request->type === 'body') {
            $posts = Post::where('body', 'like', '%'.$request->keyword.'%')->orderBy('created_at','desc')->paginate(4);
        }
        if (!isset($request->type)) {
            $posts = $this->orderBy('created_at','desc')->paginate(4);
        }

        return $posts;
    }
}
