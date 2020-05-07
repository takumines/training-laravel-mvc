@extends('layouts.app_admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col col-md-8 mx-auto">
            <h2 class="text-center">ユーザー一覧</h2>
        </div>
        <div class="col col-md-8 mx-auto mt-5">
            @foreach($users as $user)
                <div class="my-2 p-3 bg-white rounded shadow-sm">
                    <div class="mt-2 text-center">
                        <h3 class="d-inline">{{ $user->name }}</h3>
                        <form action="{{ route('admin.user.delete',['user' => $user->id]) }}" method="post" class="d-inline">
                            @method('DELETE')
                            @csrf
                            <input type="submit" value="削除" class="btn-lg btn-danger">
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection