<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    const ADMIN = 'Administrador';

    const USER = 'Usuário';

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)
            ->using(PermissionRole::class);
    }

    public function scopeIsAdmin($query): Builder
    {
        return $query->where('title', self::ADMIN);
    }

    public function scopeIsUser($query): Builder
    {
        return $query->where('title', self::USER);
    }
}
