<?php

namespace App\Contracts\Dao\Auth;

use Illuminate\Http\Request;

interface AuthDaoInterface
{
  public function saveUser(Request $request);
}
