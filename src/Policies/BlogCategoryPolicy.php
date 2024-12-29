<?php

namespace Innoboxrr\LaravelBlog\Policies;

use App\Models\User;
use Innoboxrr\LaravelBlog\Models\BlogCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogCategoryPolicy
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

    public function view(User $user, BlogCategory $blogCategory)
    {
        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, BlogCategory $blogCategory)
    {
        return false;
    }

    public function delete(User $user, BlogCategory $blogCategory)
    {
        return false;
    }

    public function restore(User $user, BlogCategory $blogCategory)
    {
        return false;
    }

    public function forceDelete(User $user, BlogCategory $blogCategory)
    {
        return false;
    }

    public function export(User $user)
    {
        return false;
    }

}
