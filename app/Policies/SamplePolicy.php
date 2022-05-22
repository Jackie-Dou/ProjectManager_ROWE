<?php


namespace App\Policies;


use App\Models\Project;
use App\Models\Sample;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SamplePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User|null $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User|null $user
     * @param \App\Models\Sample $sample
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(?User $user, Sample $sample)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can sort models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function sort(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sample $sample
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Sample $sample)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sample $sample
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Sample $sample)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sample $sample
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Sample $sample)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Sample $sample
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Sample $sample)
    {
        return false;
    }
}
