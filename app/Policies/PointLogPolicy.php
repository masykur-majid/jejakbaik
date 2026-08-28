<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PointLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class PointLogPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PointLog');
    }

    public function view(AuthUser $authUser, PointLog $pointLog): bool
    {
        return $authUser->can('View:PointLog');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PointLog');
    }

    public function update(AuthUser $authUser, PointLog $pointLog): bool
    {
        return $authUser->can('Update:PointLog');
    }

    public function delete(AuthUser $authUser, PointLog $pointLog): bool
    {
        return $authUser->can('Delete:PointLog');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PointLog');
    }

    public function restore(AuthUser $authUser, PointLog $pointLog): bool
    {
        return $authUser->can('Restore:PointLog');
    }

    public function forceDelete(AuthUser $authUser, PointLog $pointLog): bool
    {
        return $authUser->can('ForceDelete:PointLog');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PointLog');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PointLog');
    }

    public function replicate(AuthUser $authUser, PointLog $pointLog): bool
    {
        return $authUser->can('Replicate:PointLog');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PointLog');
    }

    public function manage(AuthUser $authUser): bool
    {
        return $authUser->can('Manage:PointLog');
    }

}