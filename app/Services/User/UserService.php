<?php

namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;
use Illuminate\Http\Request;

class UserService implements UserServiceInterface
{
  private $userDao;

  public function __construct(UserDaoInterface $userDao)
  {
    $this->userDao = $userDao;
  }

  public function getUserList(Request $request)
  {
    return $this->userDao->getUserList($request);
  }

  public function getUserById($id)
  {
    return $this->userDao->getUserById($id);
  }

  public function updateUser(Request $request)
  {
    $user = $this->userDao->updateUser($request);
    return $user;
  }

  public function deleteUserById($id, $deletedUserId)
  {
    return $this->userDao->deleteUserById($id, $deletedUserId);
  }

  public function changeUserPassword($validated) {
    return $this->userDao->changeUserPassword($validated);
  }
}
