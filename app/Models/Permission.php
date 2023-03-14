<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_title',
        'route_name',
        'is_default',
        'company_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    const REQUESTS_TITLE = 'requests';

    const REQUESTS_NAME = 'Solicitações';

    const USERS_TITLE = 'users';

    const USERS_NAME = 'Usuários';

    const EMPLOYEES_TITLE = 'employees';

    const EMPLOYEES_NAME = 'Funcionários';

    const COMPANY_TITLE = 'company';

    const COMPANY_NAME = 'Empresa';

    const PROFILE_TITLE = 'profile';

    const PROFILE_NAME = 'Perfil';

    const DASHBOARD_TITLE = 'dashboard';

    const DASHBOARD_NAME = 'Dashboard';

    const ROLES_TITLE = 'roles';

    const ROLES_NAME = 'Funções';

    const PERMISSIONS_TITLE = 'permissions';

    const PERMISSIONS_NAME = 'Permissões';

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
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

    public function scopeIsUsersPermission(Builder $query): void
    {
        $query->where('route_title', self::USERS_TITLE);
    }

    public function scopeIsRequestsPermission(Builder $query): void
    {
        $query->where('route_title', self::REQUESTS_TITLE);
    }

    public function scopeIsEmployeesPermission(Builder $query): void
    {
        $query->where('route_title', self::EMPLOYEES_TITLE);
    }

    public function scopeIsCompanyPermission(Builder $query): void
    {
        $query->where('route_title', self::COMPANY_TITLE);
    }

    public function scopeIsProfilePermission(Builder $query): void
    {
        $query->where('route_title', self::PROFILE_TITLE);
    }

    public function scopeIsDashboardPermission(Builder $query): void
    {
        $query->where('route_title', self::DASHBOARD_TITLE);
    }

    public function scopeIsRolesPermission(Builder $query): void
    {
        $query->where('route_title', self::ROLES_TITLE);
    }

    public function scopeIsPermissionsPermission(Builder $query): void
    {
        $query->where('route_title', self::PERMISSIONS_TITLE);
    }

    public function scopeRelatedToUserCompanyOrDefault(Builder $query): void
    {
        $query->where(function (Builder $builder) {
            $builder->where('company_id', auth()->user()->company_id);
            $builder->orWhere('is_default', true);
        });
    }

    public function scopeRelatedToUserCompany(Builder $query): void
    {
        $query->where('company_id', auth()->user()->company_id);
    }
}
