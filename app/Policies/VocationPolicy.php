<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Vocation;
use Illuminate\Auth\Access\HandlesAuthorization;

class VocationPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Vocation');
    }

    public function view(AuthUser $authUser, Vocation $vocation): bool
    {
        return $authUser->can('View:Vocation');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Vocation');
    }

    public function update(AuthUser $authUser, Vocation $vocation): bool
    {
        return $authUser->can('Update:Vocation');
    }

    public function delete(AuthUser $authUser, Vocation $vocation): bool
    {
        return $authUser->can('Delete:Vocation');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Vocation');
    }

    public function restore(AuthUser $authUser, Vocation $vocation): bool
    {
        return $authUser->can('Restore:Vocation');
    }

    public function forceDelete(AuthUser $authUser, Vocation $vocation): bool
    {
        return $authUser->can('ForceDelete:Vocation');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Vocation');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Vocation');
    }

    public function replicate(AuthUser $authUser, Vocation $vocation): bool
    {
        return $authUser->can('Replicate:Vocation');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Vocation');
    }

    public function manage(AuthUser $authUser): bool
    {
        return $authUser->can('Manage:Vocation');
    }

}