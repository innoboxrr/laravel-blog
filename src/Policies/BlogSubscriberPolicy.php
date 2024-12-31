<?php

namespace Innoboxrr\LaravelBlog\Policies;

use App\Models\User;
use Innoboxrr\LaravelBlog\Models\BlogSubscriber;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogSubscriberPolicy
{
    use HandlesAuthorization;

    /**
     * Superusuario con todas las capacidades, excepto las indicadas en la configuración.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return bool|null
     */
    public function before(User $user, $ability)
    {
        $exceptAbilities = config('laravel-blog.permissions.blog-subscriber-except-abilities', []);

        if (method_exists($user, 'isAdmin') && $user->isAdmin() && !in_array($ability, $exceptAbilities)) {
            return true;
        }

        return null;
    }

    /**
     * Comprueba si el usuario puede listar los suscriptores.
     */
    public function index(User $user)
    {
        return $this->callUserMethod($user, 'indexBlogSubscriber');
    }

    /**
     * Comprueba si el usuario puede ver cualquier suscriptor.
     */
    public function viewAny(User $user)
    {
        return $this->callUserMethod($user, 'viewAnyBlogSubscriber');
    }

    /**
     * Comprueba si el usuario puede ver un suscriptor específico.
     */
    public function view(User $user, BlogSubscriber $blogSubscriber)
    {
        return $this->callUserMethod($user, 'viewBlogSubscriber', $blogSubscriber);
    }

    /**
     * Comprueba si el usuario puede crear un suscriptor.
     */
    public function create(User $user)
    {
        return $this->callUserMethod($user, 'createBlogSubscriber');
    }

    /**
     * Comprueba si el usuario puede actualizar un suscriptor.
     */
    public function update(User $user, BlogSubscriber $blogSubscriber)
    {
        return $this->callUserMethod($user, 'updateBlogSubscriber', $blogSubscriber);
    }

    /**
     * Comprueba si el usuario puede eliminar un suscriptor.
     */
    public function delete(User $user, BlogSubscriber $blogSubscriber)
    {
        return $this->callUserMethod($user, 'deleteBlogSubscriber', $blogSubscriber);
    }

    /**
     * Comprueba si el usuario puede restaurar un suscriptor eliminado.
     */
    public function restore(User $user, BlogSubscriber $blogSubscriber)
    {
        return $this->callUserMethod($user, 'restoreBlogSubscriber', $blogSubscriber);
    }

    /**
     * Comprueba si el usuario puede eliminar un suscriptor de forma permanente.
     */
    public function forceDelete(User $user, BlogSubscriber $blogSubscriber)
    {
        return $this->callUserMethod($user, 'forceDeleteBlogSubscriber', $blogSubscriber);
    }

    /**
     * Comprueba si el usuario puede exportar los datos de suscriptores.
     */
    public function export(User $user)
    {
        return $this->callUserMethod($user, 'exportBlogSubscriber');
    }

    /**
     * Llama dinámicamente a un método en el modelo de usuario.
     *
     * @param  \App\Models\User  $user
     * @param  string  $method
     * @param  mixed  ...$arguments
     * @return bool
     */
    protected function callUserMethod(User $user, string $method, ...$arguments): bool
    {
        return method_exists($user, $method) ? $user->{$method}(...$arguments) : false;
    }
}
