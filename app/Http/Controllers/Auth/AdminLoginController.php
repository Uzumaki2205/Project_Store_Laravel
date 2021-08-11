<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\False_;

class AdminLoginController extends Controller
{
    public function showLogin()
    {
        if (Auth::check())
            return redirect('/admin/index');
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ['username' => 'required|string', 'password' => 'required',]
        );

        if ($validator->fails())
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();

        $login = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($login)) {
            return redirect('/admin/index');
        } else {
            return redirect()->back()
                ->withErrors(
                    'status',
                    'Username or Password is not available!!'
                );
        }
    }
}
