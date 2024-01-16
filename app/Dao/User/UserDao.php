<?php

namespace App\Dao\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserDao implements UserDaoInterface
{
  public function getUserList(Request $request)
  {
    $pageSize = $request->page_size ?? 10;
    $userList = User::query();

    if ($request->has('search_name')) {
      $userList = $userList->where('name', 'like', '%' . $request->search_name . '%');
    }
    if ($request->has('search_email')) {
      $userList = $userList->where('email', 'like', '%' . $request->search_email . '%');
    }
    if (!empty($request->date_start)) {
      $userList = $userList->whereDate('created_at', '>=', $request->date_start);
    }
    if (!empty($request->date_end)) {
      $userList = $userList->whereDate('created_at', '<=', $request->date_end);
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
    $user = User::find(auth()->user()->id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->profile = $request->profile;
    $user->type = $request->type;
    $user->phone = $request->phone;
    $user->dob = $request->dob;
    $user->address = $request->address;
    $user->updated_user_id = auth()->user()->id;
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
        'updated_user_id' => auth()->user()->id
      ]);
    return $user;
  }
}
