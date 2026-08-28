<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ConductRule;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConductRulePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ConductRule');
    }

    public function view(AuthUser $authUser, ConductRule $conductRule): bool
    {
        return $authUser->can('View:ConductRule');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ConductRule');
    }

    public function update(AuthUser $authUser, ConductRule $conductRule): bool
    {
        return $authUser->can('Update:ConductRule');
    }

    public function delete(AuthUser $authUser, ConductRule $conductRule): bool
    {
        return $authUser->can('Delete:ConductRule');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ConductRule');
    }

    public function restore(AuthUser $authUser, ConductRule $conductRule): bool
    {
        return $authUser->can('Restore:ConductRule');
    }

    public function forceDelete(AuthUser $authUser, ConductRule $conductRule): bool
    {
        return $authUser->can('ForceDelete:ConductRule');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ConductRule');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ConductRule');
    }

    public function replicate(AuthUser $authUser, ConductRule $conductRule): bool
    {
        return $authUser->can('Replicate:ConductRule');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ConductRule');
    }

    public function manage(AuthUser $authUser): bool
    {
        return $authUser->can('Manage:ConductRule');
    }

}