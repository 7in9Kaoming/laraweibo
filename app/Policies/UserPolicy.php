<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
    * 更新个人资料授权策略
    *
    * @param User $currentUser 默认为当前登录用户实例
    *
    * @param User $user 所要更改的用户实例
    */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

   /*
   *
   */
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && ($currentUser->id !== $user->id);
    }
}
