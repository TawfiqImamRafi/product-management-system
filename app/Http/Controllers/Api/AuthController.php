<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\AuthApi\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $auth;
    protected $guard = 'api';

    public function __construct(AuthRepositoryInterface $auth)
    {
        $this->auth = $auth;
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'mobile' => 'required|numeric|digits_between:9,11|unique:users,mobile',
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validation->errors()
            ]);
        }

        $register = $this->auth->register($request);

        if ($register) {
            return response()->json([
                'status' => true,
                'user' => $register,
                'message' => 'Successfully registered'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to registered'
        ]);
    }

    public function login(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validation->errors()
            ]);
        }

        return $this->auth->login($request);
    }

    public function me()
    {
        return $this->auth->authUser();
    }

    public function logout()
    {
        return $this->auth->logout();
    }

    
}
