<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\TRInfaq;
use App\Models\User;

class TRInfaqPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TRInfaq $tRInfaq): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TRInfaq $tRInfaq): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TRInfaq $tRInfaq): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TRInfaq $tRInfaq): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TRInfaq $tRInfaq): bool
    {
        //
    }
}
