<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        // makeVisible方法临时显示User模型里指定的隐藏属性$hidden
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        $user = User::find(1);
        $user->name = 'lingkaoming';
        $user->email = 'lingkaoming@weibo.com';
        $user->save();
    }
}
