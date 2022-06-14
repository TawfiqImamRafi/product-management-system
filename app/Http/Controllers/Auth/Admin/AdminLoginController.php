<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * find username or email
     *
     * @return string
     */
    public function username()
    {
        if (filter_var(request()->email, FILTER_VALIDATE_EMAIL)) {
            return 'email';
        } elseif(preg_match('/^[0-9]{11}+$/', request()->email)){
            return 'mobile';
        } else {
            return 'username';
        }
    }

    /**
     * login validtion
     *
     * @return string
     */
    public function loginValidation(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];

        $message = [
            'email.required' => 'Email or Mobile or username is required'
        ];

        $this->validate($request, $rules, $message);
    }

    public function login(Request $request)
    {
        $this->loginValidation($request);

        //attempt login with usename or email
        Auth::guard('admin')->attempt([$this->username() => $request->email, 'password' => $request->password]);

        //attempt login
        if (Auth::guard('admin')->check()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        //something went wrong during authentication
        return redirect()->back()->withErrors([
            'email' => 'The credential you have give is wrong, try once again'
        ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }
}
