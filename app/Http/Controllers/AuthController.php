<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

/**
 * Created by PhpStorm.
 * User: WhiteBlue
 * Date: 15/7/8
 * Time: 下午9:06
 */
class AuthController extends Controller
{

    public function getLogin()
    {
        return view("auth.login");
    }


    public function getRegister()
    {
        return view("auth.register");
    }

    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|alpha|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|alpha_num|between:6,12|confirmed',
            'password_confirmation' => 'required|alpha_num|between:6,12'
        ]);

        $user = new User;//实例化User对象
        $user->name = Input::get('username');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->save();

        return redirect('/auth/login')->with('message', '注册成功,请登录');

    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|alpha_num|between:6,12'
        ]);

        //认证凭证
        $credentials = [
            'email' => Input::get('email'),
            'password' => Input::get('password')
        ];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return redirect('/')->with('message', '登陆成功');
        } else {
            // 登录失败，跳回
            return redirect()->back()
                ->withInput()
                ->withErrors(array('attempt' => '“用户名”或“密码”错误!'));  //回传错误信息
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect('/')->with('message', '注销成功!');
    }

}