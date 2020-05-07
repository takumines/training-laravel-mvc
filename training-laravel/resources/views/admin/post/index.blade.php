@extends('layouts.app_admin')

@section('content')
    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif
    <div class="text-center">
        <form action="{{ route('admin.post.list') }}" method="get" class="mb-4">
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
                        <div class="card-body">
                            @foreach ($tags as $tag)
                                <h3>
                                    <a href="/admin/tag/search/{{ $tag->id }}">{{ $tag->category }}</a>
                                    <form class="d-inline" action="{{ route('admin.tag.delete', ['tag' => $tag->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="削除" class="btn btn-md btn-danger">
                                    </form>
                                </h3>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        @foreach( $posts as $post )
                            <div class="col-md-4">
                                <div class="card mb-4 shadow-sm">
                                    @if (isset($post->image))
                                        <img src="{{ $post->image }}" class="card-img-top">
                                    @else
                                        <img src="{{ asset('images/no-image.jpg') }}" alt="" class="card-img-top">
                                    @endif
                                    <div class="card-body bg-light">
                                        <h3 class="card-title"><a href="{{ route('admin.post.show',['post' => $post->id]) }}">{{ $post->title }}</a></h3>
                                        <p>投稿者：{{ $post->user->name }}</p>
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