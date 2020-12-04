<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function postLogin(Request $request){
        $log = [
            'email'=>$request->email,
            'password'=>$request->password
        ];

        $validator = $request->validate([
            'email.required' => 'Email khong de trong' ,
            'password.required' => 'Password khong de trong'
        ]);

        if(Auth::attempt($log))
        {
            return redirect('/customers');
        }else{
            return redirect()->withErrors($validator);
        }
    }

    public function logout(Request $request){
        Auth::guard()->logout();

        $request->session()->invalidate();
        return redirect('/');
    }

    public function register(){
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $validated = $request->validate([
            'email' => 'unique:users' ,
            'password' => 'min:6|confirmed'
        ],[
            'email.unique' => 'Email đã tồn tại' ,
            'password.min' => 'Mật khẩu có ít nhất 6 ký tự' ,
            'password.confirmed' => 'Mật khẩu không trùng khớp' ,
        ]);


        $register = new User();
        $register->name = $request->name;
        $register->email = $request->email;
        $register->password = bcrypt($request->password);
        $register->type = 4;
        $register->save();

        if($register){
            return redirect('/');

        }else{
            return redirect()->withErrors($validated);
        }
    }

}
