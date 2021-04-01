<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if($user->role === 'adminer'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        if($user->role === 'adminer'){
            return true;
        }else{
            return $user->uuid == $model->uuid;//只能查看自己信息
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->role === 'adminer'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        if($user->role === 'adminer'){
            return true;
        }else{
            return $user->uuid == $model->uuid;//只能操作自己
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        if($user->role === 'adminer'){
            return $model->role !== 'adminer';//不能删除自己
        }else{
            return false;
        }
    }

}
