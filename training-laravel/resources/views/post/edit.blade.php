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
        <h2 class="test-center">記事編集画面</h2>
        <div class="form-control">
            <form action="/post/{{ $post->id }}/edit" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <label for="title">タイトル<br>
                    <input type="text" name="title" value="{{ $post->title }}">
                </label> <br>
                <label for="body">本文<br>
                    <textarea name="body"cols="30" rows="10">{{ $post->body }}</textarea>
                </label> <br>
                <label for="image">写真<br>
                    <input type="file" name="image" value="{{ $post->image }}">
                </label>

                <div class="test-center">
                    <button type="submit" class="btn btn-primary">投稿</button>
                </div>
            </form>
        </div>
    </div>
@endsection