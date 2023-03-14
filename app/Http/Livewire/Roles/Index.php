<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
use App\Models\User;
use App\Traits\Showable;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\Event;

class Index extends Component
{
    use Showable;

    public string $search = '';

    protected $updatesQueryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->fill(request()->only('search'));
    }

    public function destroy($id): Event
    {
        $hasSomeUserAttached = User::relatedToUserCompany()->where('role_id', $id)->exists();

        if ($hasSomeUserAttached) {
            return $this->emit('alert', [
                'type' => 'warning',
                'message' => 'Função não pode ser excluída, existem usuários utilizando!',
            ]);
        }

        $role = Role::find($id);
        $role->delete();

        return $this->emit('alert', [
            'type' => 'success',
            'message' => 'Excluído com sucesso!',
        ]);
    }

    public function render()
    {
        $roles = Role::where(function (Builder $builder) {
            if ($this->search) {
                $builder->where(function (Builder $query) {
                    $query->where('title', 'like', '%'.$this->search.'%');
                });
            }
        })->relatedToUserCompanyOrDefault()->orderBy('title')->get();

        return view('livewire.roles.index', compact(['roles']));
    }
}
