<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store']
        ]);

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
		return view('users.create');
	}


    /**
    * 创建用户（注册）逻辑
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|max:50',
            'email'    => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }

    /**
    * 显示个人页面
    */
	public function show(User $user)
	{
		return view('users.show', compact('user'));
	}

    /**
    * 显示个人资料编辑表单
    */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
    * 用户资料更新逻辑
    */
    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
        // 不填密码时，只验证和更新名字
        $this->validate($request, [
            'name' => 'required|max:50'
        ]);

        $data = [];
        $data['name'] = $request->name;

        // 填写了密码时，验证和更新密码
        if ($request->password || $request->password_confirmation) {
            $this->validate($request, [
                'password' => 'confirmed|min:6'
            ]);
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);
        session()->flash('success', '个人资料更新成功！');
        return redirect()->route('users.show', $user->id);
    }
}
