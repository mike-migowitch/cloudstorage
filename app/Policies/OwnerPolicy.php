<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class OwnerPolicy
{
    use HandlesAuthorization;

    private function check(User $user, Model $model) : bool
    {
        return $user->id === $model->user_id;
    }

    public function view(User $user, Model $model)
    {
        return $this->check($user, $model);
    }

    public function update(User $user, Model $model)
    {
        return $this->check($user, $model);
    }

    public function delete(User $user, Model $model)
    {
        return $this->check($user, $model);
    }
}
