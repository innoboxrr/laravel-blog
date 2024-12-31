<?php

namespace Innoboxrr\LaravelBlog\Policies;

use App\Models\User;
use Innoboxrr\LaravelBlog\Models\BlogCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Handle all abilities for admins before checking specific methods.
     */
    public function before($user, $ability)
    {
        $exceptAbilities = config('laravel-blog.permissions.blog-category-except-abilities', []);

        if (method_exists($user, 'isAdmin') && $user->isAdmin() && !in_array($ability, $exceptAbilities)) {
            return true;
        }
    }

    /**
     * Centralized method to call user-defined methods.
     */
    protected function callUserMethod(User $user, string $method, ...$arguments): bool
    {
        return method_exists($user, $method) ? $user->{$method}(...$arguments) : false;
    }

    public function index(User $user)
    {
        return $this->callUserMethod($user, 'indexBlogCategory');
    }

    public function viewAny(User $user)
    {
        return $this->callUserMethod($user, 'viewAnyBlogCategory');
    }

    public function view(User $user, BlogCategory $blogCategory)
    {
        return $this->callUserMethod($user, 'viewBlogCategory', $blogCategory);
    }

    public function create(User $user)
    {
        return $this->callUserMethod($user, 'createBlogCategory');
    }

    public function update(User $user, BlogCategory $blogCategory)
    {
        return $this->callUserMethod($user, 'updateBlogCategory', $blogCategory);
    }

    public function delete(User $user, BlogCategory $blogCategory)
    {
        return $this->callUserMethod($user, 'deleteBlogCategory', $blogCategory);
    }

    public function restore(User $user, BlogCategory $blogCategory)
    {
        return $this->callUserMethod($user, 'restoreBlogCategory', $blogCategory);
    }

    public function forceDelete(User $user, BlogCategory $blogCategory)
    {
        return $this->callUserMethod($user, 'forceDeleteBlogCategory', $blogCategory);
    }

    public function export(User $user)
    {
        return $this->callUserMethod($user, 'exportBlogCategory');
    }
}
