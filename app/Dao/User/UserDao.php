<?php

namespace App\Dao\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserDao implements UserDaoInterface
{
  public function getUserList(Request $request)
  {
    $pageSize = $request->input('page_size', 10);
    $userList = DB::table('users as user')
      ->join('users as created_user', 'user.created_user_id', '=', 'created_user.id')
      ->join('users as updated_user', 'user.updated_user_id', '=', 'updated_user.id')
      ->select('user.*', 'created_user.name as created_user', 'updated_user.name as updated_user')
      ->whereNull('user.deleted_at');
    if (request()->has('search-name')) {
      $userList = $userList->where('user.name', 'like', '%' . request()->get('search-name', '') . '%');
    }
    if (request()->has('search-email')) {
      $userList = $userList->where('user.email', 'like', '%' . request()->get('search-email', '') . '%');
    }
    if (!empty($request->dateStart)) {
      $userList = $userList->whereDate('user.created_at', '>=', request()->get('dateStart'));
    }
    if (!empty($request->dateEnd)) {
      $userList = $userList->whereDate('user.created_at', '<=', request()->get('dateEnd'));
    }
    return $userList->paginate($pageSize);
  }

  public function getUserById($id)
  {
    $user = User::find($id);
    if (!Storage::disk('public')->exists('images/' . $user->profile)) {
      $user->profile = 'default.jpg';
  }
    return $user;
  }

  public function updateUser(Request $request)
  {
    $user = User::find(Auth::user()->id);
    $user->name = $request['name'];
    $user->email = $request['email'];
    $user->profile = $request['profile'];
    $user->type = $request['type'];
    $user->phone = $request['phone'];
    $user->dob = $request['dob'];
    $user->address = $request['address'];
    $user->updated_user_id = Auth::user()->id;
    $user->save();
    return $user;
  }

  public function deleteUserById($id, $deletedUserId)
  {
    $user = User::find($id);
    if ($user) {
      $user->deleted_user_id = $deletedUserId;
      $user->save();
      $user->delete();
      return 'User Deleted Successfully!';
    }
    return 'User Not Found!';
  }

  public function changeUserPassword($validated)
  {
    $user = User::find(auth()->user()->id)
      ->update([
        'password' => Hash::make($validated['new_password']),
        'updated_user_id' => Auth::user()->id
      ]);
    return $user;
  }
}
