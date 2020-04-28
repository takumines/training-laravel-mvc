@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col col-md-8 mx-auto">
                <h2 class="text-center">記事編集画面</h2>
                <form action="/post/{{$post->id}}/edit" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="title">タイトル</label>
                        <input class="form-control" type="text" name="title" value="{{ $post->title }}">
                    </div>
                    <div class="form-group">
                        <label for="body">本文</label>
                        <textarea class="form-control" name="body"cols="30" rows="10">{{ $post->body }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">写真</label>
                        <input class="form-control-file" type="file" name="image">
                    </div>
                    @if (!isset($tags))
                        <p class="text-center">選択できるタグがありません</p>
                    @else
                        @foreach ($tags as $tag)
                            <h4 class="d-inline mr-3">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    @for ($i = 0;$i < count($selectTags); $i++)
                                        @if ($selectTags[$i]->id === $tag->id) checked @endif
                                    @endfor>{{ $tag->category }}
                            </h4>
                        @endforeach
                    @endif
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-lg btn-primary">投稿</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection