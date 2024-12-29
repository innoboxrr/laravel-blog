<?php

namespace Innoboxrr\LaravelBlog\Policies;

use App\Models\User;
use Innoboxrr\LaravelBlog\Models\Blog;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {

        $exceptAbilities = [];

        if($user->isAdmin() && !in_array($ability, $exceptAbilities)){
        
            return true;
            
        }

    }

    public function index(User $user)
    {
        return false;
    }

    public function viewAny(User $user)
    {
        return false;
    }

    public function view(User $user, Blog $blog)
    {
        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, Blog $blog)
    {
        return false;
    }

    public function delete(User $user, Blog $blog)
    {
        return false;
    }

    public function restore(User $user, Blog $blog)
    {
        return false;
    }

    public function forceDelete(User $user, Blog $blog)
    {
        return false;
    }

    public function export(User $user)
    {
        return false;
    }

}
