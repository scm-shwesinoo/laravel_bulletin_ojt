<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\Auth\AuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    private $authInterface;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthServiceInterface $authServiceInterface)
    {
        $this->middleware('auth');
        $this->authInterface = $authServiceInterface;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    // protected function create(array $data)
    // {
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //     ]);
    // }

    public function showRegistrationView()
    {
        if (Storage::disk('public')->exists('images/' . session('profileName'))) {
            Storage::disk('public')->delete('images/' . session('profileName'));
        }

        return view('auth.register');
    }

    public function submitRegistrationView(UserRegisterRequest $request)
    {
        $validator = validator($request->all());
        $fileName = time() . '.' . $request->profile->extension();
        $request->profile->storeAs('public/images', $fileName);
        session(['profileName' => $fileName]);
        return redirect()
            ->route('register.confirm')
            ->withInput();
    }

    public function showRegistrationConfirmView()
    {
        if (old()) {
            return view('auth.register-confirm');
        }
        return redirect()
            ->route('userlist');
    }

    public function submitRegistrationConfirmView(Request $request)
    {
        $user = $this->authInterface->saveUser($request);
        return redirect()
            ->route('userlist')->with('success', 'User created successfully!');
    }
}
