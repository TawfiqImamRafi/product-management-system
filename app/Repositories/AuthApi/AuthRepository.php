<?php

namespace App\Repositories\AuthApi;

use App\Mail\UserEmailVerification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthRepository implements AuthRepositoryInterface {

    public function register($request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));
        $user->verification_code = mt_rand(11111111, 99999999);

        if ($user->save()) {
            
            $token = $user->createToken($request->input('username'))->accessToken;

            return response()->json([
                'status' => true,
                'token' => $token,
                'user' => $user,
                'message' => 'Registered in successfully'
            ]);
        }

        return false;
    }

    public function login($request)
    {
        //credentials
        $credentials = [
            $this->username($request->input('username')) => $request->input('username'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken($request->input('username'))->accessToken;
            $user = Auth::user();

            return response()->json([
                'status' => true,
                'token' => $token,
                'user' => $user,
                'message' => 'Logged in successfully'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to login. Invalid username or password'
        ]);
    }

    public function authUser()
    {
        $user = Auth::guard('api')->user();
        if ($user) {
            return response()->json([
                'status' => true,
                'user' => $user,
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid user'
        ]);
    }

    public function logout()
    {
        $user = Auth::guard('api')->user()->token();
        $user->revoke();

        return response()->json([
            'status' => true,
            'message' => 'Logout successfully',
        ]);

    }

    public function username($username)
    {
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        } elseif(preg_match('/^[0-9]{11}+$/', $username)){
            return 'mobile';
        }

        return 'username';
    }
}
