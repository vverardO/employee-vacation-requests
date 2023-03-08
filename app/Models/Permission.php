<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'route_title',
        'route_name',
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

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->using(PermissionRole::class);
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
}
