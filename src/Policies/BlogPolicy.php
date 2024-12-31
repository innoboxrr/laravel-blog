<?php

namespace Innoboxrr\LaravelBlog\Policies;

use App\Models\User;
use Innoboxrr\LaravelBlog\Models\Blog;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    /**
     * Hook de autorización previo para administradores.
     *
     * @param User $user
     * @param string $ability
     * @return bool|null
     */
    public function before($user, $ability)
    {
        $exceptAbilities = config('laravel-blog.permissions.blog-except-abilities', []);

        if (method_exists($user, 'isAdmin') && $user->isAdmin() && !in_array($ability, $exceptAbilities)) {
            return true;
        }

        return null;
    }

    /**
     * Autorizar listar todos los blogs.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $this->callUserMethod($user, 'indexBlog');
    }

    /**
     * Autorizar visualizar cualquier blog.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $this->callUserMethod($user, 'viewAnyBlog');
    }

    /**
     * Autorizar visualizar un blog específico.
     *
     * @param User $user
     * @param Blog $blog
     * @return bool
     */
    public function view(User $user, Blog $blog)
    {
        return $this->callUserMethod($user, 'viewBlog', $blog);
    }

    /**
     * Autorizar creación de un blog.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $this->callUserMethod($user, 'createBlog');
    }

    /**
     * Autorizar actualización de un blog.
     *
     * @param User $user
     * @param Blog $blog
     * @return bool
     */
    public function update(User $user, Blog $blog)
    {
        return $this->callUserMethod($user, 'updateBlog', $blog);
    }

    /**
     * Autorizar eliminación de un blog.
     *
     * @param User $user
     * @param Blog $blog
     * @return bool
     */
    public function delete(User $user, Blog $blog)
    {
        return $this->callUserMethod($user, 'deleteBlog', $blog);
    }

    /**
     * Autorizar restauración de un blog.
     *
     * @param User $user
     * @param Blog $blog
     * @return bool
     */
    public function restore(User $user, Blog $blog)
    {
        return $this->callUserMethod($user, 'restoreBlog', $blog);
    }

    /**
     * Autorizar eliminación forzada de un blog.
     *
     * @param User $user
     * @param Blog $blog
     * @return bool
     */
    public function forceDelete(User $user, Blog $blog)
    {
        return $this->callUserMethod($user, 'forceDeleteBlog', $blog);
    }

    /**
     * Autorizar exportación de blogs.
     *
     * @param User $user
     * @return bool
     */
    public function export(User $user)
    {
        return $this->callUserMethod($user, 'exportBlog');
    }

    /**
     * Llamar al método del usuario si existe.
     *
     * @param User $user
     * @param string $method
     * @param mixed ...$args
     * @return bool
     */
    private function callUserMethod(User $user, string $method, ...$args)
    {
        return method_exists($user, $method) ? $user->{$method}(...$args) : false;
    }
}
