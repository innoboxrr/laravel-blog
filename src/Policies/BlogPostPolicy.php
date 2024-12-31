<?php

namespace Innoboxrr\LaravelBlog\Policies;

use App\Models\User;
use Innoboxrr\LaravelBlog\Models\BlogPost;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPostPolicy
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
        $exceptAbilities = config('laravel-blog.permissions.blog-post-except-abilities', []);

        if (method_exists($user, 'isAdmin') && $user->isAdmin() && !in_array($ability, $exceptAbilities)) {
            return true;
        }

        return null;
    }

    /**
     * Autorizar listar todos los posts.
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $this->callUserMethod($user, 'indexBlogPost');
    }

    /**
     * Autorizar visualizar cualquier post.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $this->callUserMethod($user, 'viewAnyBlogPost');
    }

    /**
     * Autorizar visualizar un post específico.
     *
     * @param User $user
     * @param BlogPost $blogPost
     * @return bool
     */
    public function view(User $user, BlogPost $blogPost)
    {
        return $this->callUserMethod($user, 'viewBlogPost', $blogPost);
    }

    /**
     * Autorizar creación de un post.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $this->callUserMethod($user, 'createBlogPost');
    }

    /**
     * Autorizar actualización de un post.
     *
     * @param User $user
     * @param BlogPost $blogPost
     * @return bool
     */
    public function update(User $user, BlogPost $blogPost)
    {
        return $this->callUserMethod($user, 'updateBlogPost', $blogPost);
    }

    /**
     * Autorizar eliminación de un post.
     *
     * @param User $user
     * @param BlogPost $blogPost
     * @return bool
     */
    public function delete(User $user, BlogPost $blogPost)
    {
        return $this->callUserMethod($user, 'deleteBlogPost', $blogPost);
    }

    /**
     * Autorizar restauración de un post.
     *
     * @param User $user
     * @param BlogPost $blogPost
     * @return bool
     */
    public function restore(User $user, BlogPost $blogPost)
    {
        return $this->callUserMethod($user, 'restoreBlogPost', $blogPost);
    }

    /**
     * Autorizar eliminación forzada de un post.
     *
     * @param User $user
     * @param BlogPost $blogPost
     * @return bool
     */
    public function forceDelete(User $user, BlogPost $blogPost)
    {
        return $this->callUserMethod($user, 'forceDeleteBlogPost', $blogPost);
    }

    /**
     * Autorizar exportación de posts.
     *
     * @param User $user
     * @return bool
     */
    public function export(User $user)
    {
        return $this->callUserMethod($user, 'exportBlogPost');
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
