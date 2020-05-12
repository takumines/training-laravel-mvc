<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Post;

class UserController extends Controller
{
    /**
     * User一覧
     *
     * @return array
     */
    public function index(User $user)
    {
        $users = $user->all();

        return view('admin.user.list', [
            'users' => $users,
        ]);
    }

    public function chengeSuspension(User $user)
    {
        if ($user->status === User::STATUS_ACTIVE) {
            $user->status = User::STATUS_SUSPENSION;
            $user->save();
        }

        return redirect('/admin/users');
    }

    public function chengeActive(User $user)
    {
        if ($user->status === User::STATUS_SUSPENSION) {
            $user->status = User::STATUS_ACTIVE;
            $user->save();
        }

        return redirect('/admin/users');
    }

    /**
     * user削除
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/admin/')->with('flash_message','USERを削除しました');
    }
}
