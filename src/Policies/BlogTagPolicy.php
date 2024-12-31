<?php

namespace Innoboxrr\LaravelBlog\Policies;

use App\Models\User;
use Innoboxrr\LaravelBlog\Models\BlogTag;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogTagPolicy
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
        $exceptAbilities = config('laravel-blog.permissions.blog-tag-except-abilities', []);

        if (method_exists($user, 'isAdmin') && $user->isAdmin() && !in_array($ability, $exceptAbilities)) {
            return true;
        }

        return null;
    }

    /**
     * Autorizar listar todas las etiquetas.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $this->callUserMethod($user, 'indexBlogTag');
    }

    /**
     * Autorizar visualizar cualquier etiqueta.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $this->callUserMethod($user, 'viewAnyBlogTag');
    }

    /**
     * Autorizar visualizar una etiqueta específica.
     *
     * @param User $user
     * @param BlogTag $blogTag
     * @return bool
     */
    public function view(User $user, BlogTag $blogTag)
    {
        return $this->callUserMethod($user, 'viewBlogTag', $blogTag);
    }

    /**
     * Autorizar creación de una etiqueta.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $this->callUserMethod($user, 'createBlogTag');
    }

    /**
     * Autorizar actualización de una etiqueta.
     *
     * @param User $user
     * @param BlogTag $blogTag
     * @return bool
     */
    public function update(User $user, BlogTag $blogTag)
    {
        return $this->callUserMethod($user, 'updateBlogTag', $blogTag);
    }

    /**
     * Autorizar eliminación de una etiqueta.
     *
     * @param User $user
     * @param BlogTag $blogTag
     * @return bool
     */
    public function delete(User $user, BlogTag $blogTag)
    {
        return $this->callUserMethod($user, 'deleteBlogTag', $blogTag);
    }

    /**
     * Autorizar restauración de una etiqueta.
     *
     * @param User $user
     * @param BlogTag $blogTag
     * @return bool
     */
    public function restore(User $user, BlogTag $blogTag)
    {
        return $this->callUserMethod($user, 'restoreBlogTag', $blogTag);
    }

    /**
     * Autorizar eliminación forzada de una etiqueta.
     *
     * @param User $user
     * @param BlogTag $blogTag
     * @return bool
     */
    public function forceDelete(User $user, BlogTag $blogTag)
    {
        return $this->callUserMethod($user, 'forceDeleteBlogTag', $blogTag);
    }

    /**
     * Autorizar exportación de etiquetas.
     *
     * @param User $user
     * @return bool
     */
    public function export(User $user)
    {
        return $this->callUserMethod($user, 'exportBlogTag');
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
