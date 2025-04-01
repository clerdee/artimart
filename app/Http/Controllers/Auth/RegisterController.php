<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Customer;

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
    protected $redirectTo = '/email/verify';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:10'],
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'addressline' => ['required', 'string', 'max:255'],
            'town' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'profile_image' => ['nullable', 'mimes:jpeg,png,jpg|max:2048']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $fullName = $data['fname'] . ' ' . $data['lname'];

        if (request()->hasFile('profile_image')) {
            $path = Storage::putFileAs(
                'public/images',
                request()->file('profile_image'),
                request()->file('profile_image')->hashName()
            );
            $profileImage = str_replace('public/', '', $path); // Adjust path for access
        }
    
        // Create User
        $user = User::create([
            'name' => $fullName,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user', // Assign default role
            'profile_image' => $profileImage, // Store image path if exists
        ]);

        Customer::create([
            'user_id' => $user->id,
            'title' => $data['title'],
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'addressline' => $data['addressline'],
            'town' => $data['town'],
            'phone' => $data['phone']
        ]);

        return $user;
    }
}
