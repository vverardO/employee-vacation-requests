<?php

namespace App\Http\Livewire\Permissions;

use App\Models\Permission;
use App\Traits\Destroyable;
use App\Traits\Showable;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Index extends Component
{
    use Showable;
    use Destroyable;

    public string $search = '';

    protected $updatesQueryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->fill(request()->only('search'));
    }

    public function render()
    {
        $permissions = Permission::where(function (Builder $builder) {
            if ($this->search) {
                $builder->where(function (Builder $query) {
                    $query->where('route_title', 'like', '%'.$this->search.'%');
                    $query->orWhere('route_name', 'like', '%'.$this->search.'%');
                });
            }
        })->relatedToUserCompanyOrDefault()->orderBy('route_name')->get();

        return view('livewire.permissions.index', compact(['permissions']));
    }
}
