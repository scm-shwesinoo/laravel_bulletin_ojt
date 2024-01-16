<?php

namespace App\Dao\Auth;

use App\Contracts\Dao\Auth\AuthDaoInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthDao implements AuthDaoInterface
{
  public function saveUser(Request $request)
  {
    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->profile = $request->profile;
    $user->type = $request->type;
    $user->phone = $request->phone;
    $user->dob = $request->dob;
    $user->address = $request->address;
    $user->created_user_id = auth()->user()->id ?? 1;
    $user->updated_user_id = auth()->user()->id ?? 1;
    $user->save();
    return $user;
  }
}
