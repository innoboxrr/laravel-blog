<?php

namespace Innoboxrr\LaravelBlog\Policies;

use App\Models\User;
use Innoboxrr\LaravelBlog\Models\BlogTag;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogTagPolicy
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

    public function view(User $user, BlogTag $blogTag)
    {
        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, BlogTag $blogTag)
    {
        return false;
    }

    public function delete(User $user, BlogTag $blogTag)
    {
        return false;
    }

    public function restore(User $user, BlogTag $blogTag)
    {
        return false;
    }

    public function forceDelete(User $user, BlogTag $blogTag)
    {
        return false;
    }

    public function export(User $user)
    {
        return false;
    }

}
