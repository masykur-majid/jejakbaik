<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ClassGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassGroupPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ClassGroup');
    }

    public function view(AuthUser $authUser, ClassGroup $classGroup): bool
    {
        return $authUser->can('View:ClassGroup');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ClassGroup');
    }

    public function update(AuthUser $authUser, ClassGroup $classGroup): bool
    {
        return $authUser->can('Update:ClassGroup');
    }

    public function delete(AuthUser $authUser, ClassGroup $classGroup): bool
    {
        return $authUser->can('Delete:ClassGroup');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ClassGroup');
    }

    public function restore(AuthUser $authUser, ClassGroup $classGroup): bool
    {
        return $authUser->can('Restore:ClassGroup');
    }

    public function forceDelete(AuthUser $authUser, ClassGroup $classGroup): bool
    {
        return $authUser->can('ForceDelete:ClassGroup');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ClassGroup');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ClassGroup');
    }

    public function replicate(AuthUser $authUser, ClassGroup $classGroup): bool
    {
        return $authUser->can('Replicate:ClassGroup');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ClassGroup');
    }

    public function manage(AuthUser $authUser): bool
    {
        return $authUser->can('Manage:ClassGroup');
    }

}