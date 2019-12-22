<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    /**
    * 显示登录表单
    */
    public function create()
    {
        return view('sessions.create');
    }

    /**
    * 登录逻辑处理
    */
    public function store(Request $request)
    {
        // 获取并验证登录凭证
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            session()->flash('success', '欢迎回来！');
            return redirect()->route('users.show', [Auth::user()]);
        }
        session()->flash('danger', '佷抱歉，您的邮箱和密码不匹配');
        return redirect()->back()->withInput();
    }

    /**
    * 登出逻辑
    */
    public function destroy() {
        Auth::logout();
        session()->flash('success', '您已经成功退出！');
        return redirect('login');
    }
}
