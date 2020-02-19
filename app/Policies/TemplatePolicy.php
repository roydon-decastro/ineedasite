<?php

namespace App\Policies;

use App\Template;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TemplatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any templates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can view the template.
     *
     * @param  \App\User  $user
     * @param  \App\Template  $template
     * @return mixed
     */
    public function view(User $user, Template $template)
    {
        //This is an if statement that will return either true or false
        //if the authenticated $user->id is equal to the user_id of the $template, return true
        return $user->id == $template->user_id;
    }

    /**
     * Determine whether the user can create templates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can update the template.
     *
     * @param  \App\User  $user
     * @param  \App\Template  $template
     * @return mixed
     */
    public function update(User $user, Template $template)
    {
        //
        //This is an if statement that will return either true or false
        //if the authenticated $user->id is equal to the user_id of the $template, return true
        return $user->id == $template->user_id;
    }

    /**
     * Determine whether the user can delete the template.
     *
     * @param  \App\User  $user
     * @param  \App\Template  $template
     * @return mixed
     */
    public function delete(User $user, Template $template)
    {
        //
        //This is an if statement that will return either true or false
        //if the authenticated $user->id is equal to the user_id of the $template, return true
        return $user->id == $template->user_id;
    }

    /**
     * Determine whether the user can restore the template.
     *
     * @param  \App\User  $user
     * @param  \App\Template  $template
     * @return mixed
     */
    public function restore(User $user, Template $template)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can permanently delete the template.
     *
     * @param  \App\User  $user
     * @param  \App\Template  $template
     * @return mixed
     */
    public function forceDelete(User $user, Template $template)
    {
        //
        return false;
    }
}
