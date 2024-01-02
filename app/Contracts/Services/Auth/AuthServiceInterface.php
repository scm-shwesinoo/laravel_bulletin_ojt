<?php

namespace App\Contracts\Services\Auth;

use Illuminate\Http\Request;

interface AuthServiceInterface
{
  public function saveUser(Request $request);
}