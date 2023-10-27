<?php

/**
 * @property-read bool $encaixe
 */

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'ramal',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function encaixes(): HasMany
    {
        return $this->hasMany(Encaixe::class);
    }

    public function movimentos(): HasMany
    {
        return $this->hasMany(Encaixe_movimento::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo(string $permission): void 
    {
        $p = Permission::query()->firstOrCreate(compact('permission'));

        
        if (!$this->permissions()->where('permission', $permission)->exists()) {
            $this->permissions()->attach($p);
        }
    }

    public function removePermissionTo(string $permission): void
    {
        
        $p = Permission::query()->where('permission', $permission)->first();

        if ($p) {
          
            $this->permissions()->detach($p);
        }
    }

    public function removAllPermissions(): void
    {
        $this->permissions()->detach();
    }

    public function hasPermissionTo(string $permission): bool
    {
        return $this->permissions()->where('permission', $permission)->exists();
    }

    public function allPermissions()
    {
        return $this->permissions()->get();
    }
}
