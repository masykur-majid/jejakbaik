<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Replace 'admin' with your target panel's ID 
        // Replace $this->is_admin with your actual admin check or Spatie role check ($this->hasRole('admin'))
        if ($panel->getId() === 'admin') {
            return $this->hasRole('super_admin'); // or $this->is_admin if you have a boolean column for admin
        }

        // Allow access to other panels by default if needed
        return true;
    }
    public function student(): HasOne{
        return $this->hasOne(Student::class, 'user_id');
    }

    public function teacher(): HasOne{
        return $this->hasOne(Teacher::class, 'user_id');
    }
}
