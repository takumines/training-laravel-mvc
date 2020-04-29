<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['category'];

    /**
     * postsテーブルとの多対多のリレーション
     *
     * @return App\Post
     */
    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }

    /**
     * 選択されたタグに紐付いた記事を取得する
     *
     * @return array
     */
    public function selectTag()
    {
        $posts = $this->posts()->orderBy('created_at','desc')->paginate(6);

        return $posts;
    }
}
