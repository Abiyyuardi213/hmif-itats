<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_SUPER_ADMIN = 'super_admin';

    public const ROLE_SEKRETARIAT = 'admin_sekretariat';

    public const ROLE_KOMINFO = 'admin_kominfo';

    public const ROLE_PANITIA_PEMILU = 'panitia_pemilu';

    public const ROLES = [
        self::ROLE_SUPER_ADMIN => 'Super Admin (Kahim / Divisi 6)',
        self::ROLE_SEKRETARIAT => 'Admin Sekretariat',
        self::ROLE_KOMINFO => 'Admin Kominfo',
        self::ROLE_PANITIA_PEMILU => 'Panitia Pemilu',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function canManageContent(): bool
    {
        return $this->hasRole(self::ROLE_SUPER_ADMIN, self::ROLE_SEKRETARIAT, self::ROLE_KOMINFO);
    }

    public function canManageOrganization(): bool
    {
        return $this->hasRole(self::ROLE_SUPER_ADMIN, self::ROLE_SEKRETARIAT);
    }

    public function canManageElection(): bool
    {
        return $this->hasRole(self::ROLE_SUPER_ADMIN, self::ROLE_PANITIA_PEMILU);
    }

    public function roleLabel(): string
    {
        return self::ROLES[$this->role] ?? ucfirst(str_replace('_', ' ', (string) $this->role));
    }
}
