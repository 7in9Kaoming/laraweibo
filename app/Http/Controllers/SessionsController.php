<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        // 未登录用户可访问
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

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

        if (Auth::attempt($credentials, $request->has('remember'))) {
            if (Auth::user()->activated) {
                session()->flash('success', '欢迎回来！');
                $fallback = route('users.show', Auth::user());
                // 重定向中的 intended 方法将经由身份验证中间件将用户重定向到身份验证前截获的 URL
                return redirect()->intended($fallback);
            }
            Auth::logout();
            session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
            return redirect('/');
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
