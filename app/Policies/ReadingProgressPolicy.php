<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ReadingProgress;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReadingProgressPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ReadingProgress');
    }

    public function view(AuthUser $authUser, ReadingProgress $readingProgress): bool
    {
        return $authUser->can('View:ReadingProgress');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ReadingProgress');
    }

    public function update(AuthUser $authUser, ReadingProgress $readingProgress): bool
    {
        return $authUser->can('Update:ReadingProgress');
    }

    public function delete(AuthUser $authUser, ReadingProgress $readingProgress): bool
    {
        return $authUser->can('Delete:ReadingProgress');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ReadingProgress');
    }

    public function restore(AuthUser $authUser, ReadingProgress $readingProgress): bool
    {
        return $authUser->can('Restore:ReadingProgress');
    }

    public function forceDelete(AuthUser $authUser, ReadingProgress $readingProgress): bool
    {
        return $authUser->can('ForceDelete:ReadingProgress');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ReadingProgress');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ReadingProgress');
    }

    public function replicate(AuthUser $authUser, ReadingProgress $readingProgress): bool
    {
        return $authUser->can('Replicate:ReadingProgress');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ReadingProgress');
    }

    public function manage(AuthUser $authUser): bool
    {
        return $authUser->can('Manage:ReadingProgress');
    }

}