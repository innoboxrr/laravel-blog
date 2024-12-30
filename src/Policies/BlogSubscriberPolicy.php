<?php

namespace Innoboxrr\LaravelBlog\Policies;

use App\Models\User;
use Innoboxrr\LaravelBlog\Models\BlogSubscriber;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogSubscriberPolicy
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

    public function view(User $user, BlogSubscriber $blogSubscriber)
    {
        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, BlogSubscriber $blogSubscriber)
    {
        return false;
    }

    public function delete(User $user, BlogSubscriber $blogSubscriber)
    {
        return false;
    }

    public function restore(User $user, BlogSubscriber $blogSubscriber)
    {
        return false;
    }

    public function forceDelete(User $user, BlogSubscriber $blogSubscriber)
    {
        return false;
    }

    public function export(User $user)
    {
        return false;
    }

}
