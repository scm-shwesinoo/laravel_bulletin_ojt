<?php

namespace App\Contracts\Dao\User;

use Illuminate\Http\Request;

interface UserDaoInterface
{
  public function getUserList(Request $request);

  public function getUserById($id);

  public function updateUser(Request $request);

  public function deleteUserById($id, $deletedUserId);

  public function changeUserPassword($validated);

}
