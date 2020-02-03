<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\ProgrammingLanguages;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Contracts\Validation\Validator as Validator2;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller {
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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return Validator2
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'min:8', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'first_name' => ['required', 'string', 'min:3', 'max:50'],
            'last_name' => ['required', 'string', 'min:3', 'max:50'],
            'pesel' => ['required', 'string', 'min:11', 'max:11', 'unique:users'],
            'languages' => ['required', 'string', 'min:2', 'languages']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'pesel' => $data['pesel'],
            'password' => Hash::make($data['password']),
        ]);

        if ($user) {
            $langNames = array_map('trim', explode(',', $data['languages']));
            $langIds = [];
            foreach ($langNames as $langName) {
                $lang = ProgrammingLanguages::firstOrCreate(['name' => $langName]);
                if ($lang) {
                    $langIds[] = $lang->id;
                }
            }
            $user->languages()->sync($langIds);
        }

        return $user;
    }
    
}
