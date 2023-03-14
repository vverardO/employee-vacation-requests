<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;
    use Timestamp;

    protected $fillable = [
        'title',
        'is_default',
        'company_id',
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

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function createdAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->format('d/m/Y H:i:s'),
        );
    }

    public function scopeIsAdmin($query): Builder
    {
        return $query->where('title', self::ADMIN);
    }

    public function scopeIsUser($query): Builder
    {
        return $query->where('title', self::USER);
    }

    public function scopeRelatedToUserCompanyOrDefault(Builder $query): void
    {
        $query->where(function (Builder $builder) {
            $builder->where('company_id', auth()->user()->company_id);
            $builder->orWhere('is_default', true);
        });
    }

    public function scopeRelatedToUserCompanyOrHasUserOrDefault(Builder $query): void
    {
        $query->where(function (Builder $builder) {
            $builder->where('company_id', auth()->user()->company_id);
            $builder->orWhere('is_default', true);
            $builder->orWhereHas('users');
        });
    }

    public function scopeRelatedToUserCompany(Builder $query): void
    {
        $query->where('company_id', auth()->user()->company_id);
    }
}
