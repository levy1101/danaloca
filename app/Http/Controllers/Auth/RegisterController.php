<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http; // Thêm dòng này

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
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'dob' => 'required|date',
            'phone' => 'required|numeric',
            'gender' => 'required',
            'password' => ['required', 'string', 'min:1', 'confirmed'],
            'bio' => ['required', 'min:1'],
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
        // Lấy thông tin vị trí từ API
        $locationData = Http::get('http://ip-api.com/json/' . request()->ip())->json();

        // Kiểm tra xem các khóa 'city' và 'regionName' có tồn tại không
        $locationName = '';
        if (isset($locationData['city']) && isset($locationData['regionName'])) {
            $locationName = $locationData['city'] . ', ' . $locationData['regionName'];
        } else {
            $locationName = 'Unknown Location'; // Hoặc một giá trị mặc định khác
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'dob' => $data['dob'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'bio' => $data['bio'],
            'location' => $locationName, 
            'avatar' => "https://cdn-icons-png.flaticon.com/512/1077/1077114.png",
            'password' => Hash::make($data['password']),
        ]);
    }
}
