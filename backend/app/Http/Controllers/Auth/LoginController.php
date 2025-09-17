<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Traits\ApiHelperTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller {

    use AuthenticatesUsers, ApiHelperTrait;
    
    protected $redirectTo = 'admin';
    
    public function __construct() {
        $this->middleware('guest')->except('logout');
        $this->middleware('googleRecaptcha')->only(['login']);
    }

    public function login(LoginRequest $request) {
        $remember = ($request->remember) ? true : false;
        if (Auth::attempt(['email' => strip_tags($request->email), 'password' => strip_tags($request->password)], $remember)) {

            // if($request->ip() != '127.0.0.1') {
            //     $response = Http::get('https://ipinfo.io/'.$request->ip());
            //     $data = json_decode($response);

            //     User::where('id', auth()->id())->update([
            //         'last_login_at' => date('Y-m-d H:i:s'),
            //         'last_login_ip' => $request->ip(),
            //         'last_login_region' => $data->city . ', ' . $data->region,
            //         'last_login_coordinates' => $data->loc
            //     ]);
            // }

            return redirect('admin');
        }

        return redirect()->back()->withInput($request->only('password'))->withErrors(['password' => 'Password is incorrect']);
    }

    public function login_api(LoginRequest $request) {
        // echo '<pre>'; print_r($_SERVER['REMOTE_ADDR']); echo '</pre>'; exit;
        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password)) {
            return $this->sendError('The provided credentials are incorrect', ['Password is incorrect'], 500);
        }

        $token = $user->createToken($request->header('User-Agent'))->plainTextToken;

        $data = [
            'user' => $user,
            'token' => $token
        ];

        return $this->sendResponse($data, 'Login Success');
    }
}
