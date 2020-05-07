@extends('layouts.app_admin')

@section('content')
    <div class="container">

        <div class="row p-4 mb-6 bg-white rounded shadow-sm">
            <div class="col">
                <div class="text-center mx-auto">
                    @if (isset($post->image))
                        <img src="{{ $post->image }}" alt="" class="rounded border border-info ">
                    @else
                        <img src="{{ asset('images/no-image.jpg') }}" alt="" class="rounded border border-info">
                    @endif
                    <div class="">
                        <h1 class="text-center mb-3">{{ $post->title }}</h1>
                        <h2 class="text-center mb-3">{{ $post->body }}</h2>
                        @if (count($tags) === 0)
                            <p class="text-center">タグが選択せれていません</p>
                        @else
                            @foreach ($tags as $tag)
                                <span class="text-success">#</span>
                                <h4 class="d-inline">{{ $tag->category }}</h4>
                            @endforeach
                        @endif
                    </div>

                    @auth
                        <div class="col-12 pt-3 text-center">
                            <a class="btn btn-lg btn-primary" href="{{ route('post.edit',['post' => $post->id]) }}">編集</a>
                            <form class="d-inline" action="{{ route('admin.post.delete', ['post' => $post->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <input type="submit" value="削除" class="btn btn-lg btn-danger">
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </>
    </div>
@endsection
