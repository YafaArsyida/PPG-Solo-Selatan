<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\TRInfaqPengurus;
use App\Models\User;

class TRInfaqPengurusPolicy
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
    public function view(User $user, TRInfaqPengurus $tRInfaqPengurus): bool
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
    public function update(User $user, TRInfaqPengurus $tRInfaqPengurus): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TRInfaqPengurus $tRInfaqPengurus): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TRInfaqPengurus $tRInfaqPengurus): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TRInfaqPengurus $tRInfaqPengurus): bool
    {
        //
    }
}
