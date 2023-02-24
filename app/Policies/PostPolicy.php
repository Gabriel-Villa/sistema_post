<?php

namespace App\Policies;

use App\Models\PermisosEdicionPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Post $post)
    {
        return auth()->user()->can('editar_post') 
            || PermisosEdicionPost::query()
                ->bypost($post->id)
                ->encurso()
                ->bysolicitadopor($user->id)
                ->exists();
    }

}
