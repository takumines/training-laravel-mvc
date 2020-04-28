@extends('layouts.app')

@section('content')
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
@endsection