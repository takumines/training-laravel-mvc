@extends('layouts.app')

@section('content')
    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif
    <div class="text-center">
        <form action="{{ route('post.list') }}" method="get">
            <select name="type">
                <option value="title">タイトル</option>
                <option value="body">本文</option>
            </select>
            <input type="text" name="keyword">
            <input type="submit" value="検索">
        </form>
    </div>
    <div>
        <div>
        </div>
        @if(count($posts) === 0)
            <h3>まだ投稿がありません</h3>
        @else
            <div class="row">
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>タグ一覧</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        @foreach( $posts as $post )
                            <div class="col-sm-12 col-md-4">
                                <div class="postBox" style="border: medium solid #9d8866;">
                                    <h2>{{$post->title}}</h2>
                                    <p>{{$post->body}}</p>
                                    投稿者: <p>{{$post->user->name}}</p>
                                    <button class="btn-info btn" type="button">
                                        <a href="{{ route('post.edit',['post' => $post]) }}">編集</a>
                                    </button>
                                    <div>
                                        <form action="{{ route('post.delete', ['post' => $post]) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <input class="btn btn-danger" type="submit" value="削除">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        <div>
            {{ $posts->links() }}
        </div>
    </div>
@endsection