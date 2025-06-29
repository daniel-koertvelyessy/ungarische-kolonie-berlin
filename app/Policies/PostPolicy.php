<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Blog\Post;
use App\Models\User;
use App\Policies\Traits\HasAdminPrivileges;

class PostPolicy
{
    use HasAdminPrivileges;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $blogPost): bool
    {
        return $user->exists;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->getAdminPrivileges($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?Post $blogPost): bool
    {
        if ($blogPost && $blogPost->user_id === $user->id) {
            return true;
        }

        return $this->getAdminPrivileges($user);

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ?Post $blogPost): bool
    {
        return $this->getAdminPrivileges($user);

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $blogPost): bool
    {
        return $this->getAdminPrivileges($user);

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $blogPost): bool
    {
        return false;
    }
}
