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
            <div class="col-md-8 mx-auto">
                <h2 class="text-center">タグ追加画面</h2>
                <form action="/tag/create" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="category">タグ名</label>
                        <input class="form-control" type="text" name="category" value="{{ old('category') }}">
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" value="作成" class="btn btn-lg btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection