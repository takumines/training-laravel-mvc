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
        $this->belongsToMany('App\Post');
    }
}
