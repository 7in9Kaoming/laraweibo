<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index', 'show', 'create', 'store', 'confirmEmail']
        ]);

        // 未登录用户可访问
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    /*
    * 获取所有用户列表
    */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
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

        // 用户创建成功后，发送验证邮件到注册邮箱
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect()->route('users.show', [$user]);
    }

    /**
    * 显示个人页面
    */
	public function show(User $user)
	{
        // 获取用户所有微博
        $statuses = $user->statuses()->orderBy('created_at', 'desc')->paginate(10);

		return view('users.show', compact('user', 'statuses'));
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

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);

        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }

    /**
    * 给新注册用户发送激活邮件
    */
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'lingkaoming@eweibo.com';
        $name = 'lingkaoming';
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }

    /**
    * 激活用户, 并让用户登录
    */
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }

    // 用户关注的人列表页
    public function followings(User $user)
    {
        $users = $user->followings()->paginate(30);
        $title = $user->name . '关注的人';
        return view('users.show_follow', compact('users', 'title'));
    }

    // 用户粉丝列表页
    public function followers(User $user)
    {
        $users = $user->followers()->paginate(30);
        $title = $user->name . '的粉丝';
        return view('users.show_follow', compact('users', 'title'));
    }
}
