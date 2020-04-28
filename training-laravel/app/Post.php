<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'body', 'image'];

    /**
     * usersテーブルと1対多のリレーション
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * usersテーブルとの多対多のリレーション
     *
     * @return App\Tag
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    /**
     * 検索結果の記事または全ての記事を返す
     * @param $posts
     */
    public function postQuery($request)
    {
        if ($request->type === 'title') {
            $posts = Post::where('title', 'like', '%'.$request->keyword.'%')->orderBy('created_at','desc')->paginate(6);
        }
        if ($request->type === 'body') {
            $posts = Post::where('body', 'like', '%'.$request->keyword.'%')->orderBy('created_at','desc')->paginate(6);
        }
        if (!isset($request->type)) {
            $posts = $this->orderBy('created_at','desc')->paginate(6);
        }

        return $posts;
    }
}
