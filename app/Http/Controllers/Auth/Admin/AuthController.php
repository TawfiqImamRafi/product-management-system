<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function changePassword()
    {
        return view('admin.auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $rules = [
            'current_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ];

        $this->validate($request, $rules);

        //check current password
        if(!Hash::check($request->get('current_password'), Auth::guard('admin')->user()->password)){
            return response()->json([
                'message' => "Wrong current password",
                'errors' => [
                    'current_password' => ["Current password does not match"]
                ]
            ], 422);
        }

        $admin = Auth::guard('admin')->user();
        $admin->password = Hash::make($request->input('password'));

        if ($admin->save()) {
            return response()->json([
                'type' => 'success',
                'title' => 'Update password',
                'message' => "Password updated successfully"
            ]);
        }

        return response()->json([
            'type' => 'error',
            'title' => 'Failed!',
            'message' => "Password failed to update"
        ]);
    }
}
