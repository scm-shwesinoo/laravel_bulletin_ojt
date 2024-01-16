<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserPasswordChangeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
  private $userInterface;

  public function __construct(UserServiceInterface $userServiceInterface)
  {
    $this->middleware('auth');
    $this->userInterface = $userServiceInterface;
  }

  public function showUserList(Request $request)
  {
    $pageSize = $request->page_size ?? 10;
    $userList = $this->userInterface->getUserList($request);
    return view('users.list', compact('userList', 'pageSize'));
  }

  public function showUserProfile()
  {
    $userId = auth()->user()->id;
    $user = $this->userInterface->getUserById($userId);
    return view('users.profile', compact('user'));
  }

  public function showUserProfileEdit()
  {
    $profileName = session('profileName');
    if (auth()->user()->profile !== $profileName) {
      if (Storage::disk('public')->exists('images/' . $profileName)) {
        Storage::disk('public')->delete('images/' . $profileName);
      }
    }
    $userId = auth()->user()->id;
    $user = $this->userInterface->getUserById($userId);
    return view('users.profile-edit', compact('user'));
  }

  public function submitEditProfileView(UserEditRequest $request)
  {
    $validated = $request->validated();
    $fileName = auth()->user()->profile;
    if (array_key_exists('profile', $validated)) {
      $fileName = time() . '.' . $request->profile->extension();
      $request->profile->storeAs('public/images', $fileName);
    }
    session(['profileName' => $fileName]);
    return redirect()
      ->route('profile.edit.confirm')
      ->withInput();
  }

  public function showEditProfileConfirmView()
  {
    if (old()) {
      return view('users.profile-edit-confirm');
    }
    return redirect()->route('profile');
  }

  public function submitProfileEditConfirmView(Request $request)
  {
    $profileName = auth()->user()->profile;
    if (session('profileName') !== $profileName) {
      if (Storage::disk('public')->exists('images/' . $profileName)) {
        Storage::disk('public')->delete('images/' . $profileName);
      }
    }
    $user = $this->userInterface->updateUser($request);
    return redirect()->route('profile')->with('success', 'User Updated Successfully!');
  }

  public function deleteUserById(Request $request)
  {
    $userId = $request->user_id;
    $deletedUserId = auth()->user()->id;
    $msg = $this->userInterface->deleteUserById($userId, $deletedUserId);
    return redirect()->route('userlist')->with('info', $msg);
  }

  public function showChangePasswordView()
  {
    return view('users.change-password');
  }

  public function savePassword(UserPasswordChangeRequest $request)
  {
    // validation for request values
    $validated = $request->validated();
    $user = $this->userInterface->changeUserPassword($validated);
    return redirect()->route('profile')->with('success', 'Password changed successfully!');
  }
}
