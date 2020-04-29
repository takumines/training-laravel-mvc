<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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


    /**
     * 写真のアップロードを行う
     *
     */
    public function uploadImage($form)
    {
        if (isset($form['image']))
        {
            $extension = $form['image']->getClientOriginalExtension();
            $filename = $form['image']->getClientOriginalName();
            $resize_img = Image::make($form['image'])->resize(320, 240)->encode($extension);
            $path = Storage::disk('s3')->put('/post/'.$filename,(string)$resize_img, 'public');
            $url = Storage::disk('s3')->url('post/'.$filename);
            $this->image = $url;
        }

        if (!isset($form['image']))
        {
            $this->image = null;
        }
    }
}
