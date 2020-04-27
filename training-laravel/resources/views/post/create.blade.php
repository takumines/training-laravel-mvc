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
        <h2 class="test-center">記事投稿画面</h2>
        <div class="form-control">
            <form action="/post/create" method="post" enctype="multipart/form-data">
                @csrf
                <label for="title">タイトル<br>
                    <input type="text" name="title" value="{{ old('title') }}">
                </label> <br>
                <label for="body">本文<br>
                    <textarea name="body"cols="30" rows="10">{{ old('body') }}</textarea>
                </label> <br>
                <label for="image">写真<br>
                    <input type="file" name="image">
                </label>
                <div class="test-center">
                    <button type="submit" class="btn btn-primary">投稿</button>
                </div>
            </form>
        </div>
    </div>
@endsection