<?php

namespace App\Contracts\Services\User;

use Illuminate\Http\Request;

interface UserServiceInterface
{
  public function getUserList(Request $request);

  public function getUserById($id);

  public function updateUser(Request $request);

  public function deleteUserById($id, $deletedUserId);

  public function changeUserPassword($validated);
  
}
