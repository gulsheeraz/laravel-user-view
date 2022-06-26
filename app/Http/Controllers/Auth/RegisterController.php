<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use stdClass;
use App\Models\Department;
use App\Models\Role;
use Str;
use Carbon\Carbon;

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

    public CONST MIN_USER_AGE = 10;

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
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        // initiate instance to pass data on view
        $data = new stdClass();

        // resolve department for selection
        $data->departments  = collect(Department::pluck('name', 'id'))
            ->prepend('Select Department', '')->toArray();

        // resolve roles for selection
        $data->roles = collect(Role::pluck('name', 'id'))->toArray();

        // controll max date, user having min 10 years of age can register
        $data->maxDate = Carbon::now()->subYear(self::MIN_USER_AGE)->toDateString();

        return view('auth.register', compact('data'));
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
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
            'dob'           => ['required'],
            'department_id' => ['required', 'integer', 'unique:users'],
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
        $user = User::create([
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'name'          => Str::title($data['first_name']. ' '. $data['last_name']),
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'dob'           => $data['dob'],
            'address'       => $data['address'] ?? '',
            'department_id' => $data['department_id'],
        ]);

        $user->roles()->sync($data['role_ids']);

        return $user;
    }
}
