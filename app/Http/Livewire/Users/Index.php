<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
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

    public function grantAccess($id)
    {
        $user = User::find($id);
        $user->update(['status' => 1]);
        $user->save();

        $this->emit('alert', [
            'type' => 'success',
            'message' => 'Usuário ativado com sucesso!',
        ]);
    }

    public function revokeAccess($id)
    {
        $user = User::find($id);

        if (auth()->user()->id == $id) {
            return $this->emit('alert', [
                'type' => 'warning',
                'message' => 'Você não pode inativado o seu próprio usuário!',
            ]);
        }

        $user->update(['status' => 0]);
        $user->save();

        $this->emit('alert', [
            'type' => 'success',
            'message' => 'Usuário inativado com sucesso!',
        ]);
    }

    public function mount()
    {
        $this->fill(request()->only('search'));
    }

    public function render()
    {
        $users = User::where(function (Builder $builder) {
            if ($this->search) {
                $builder->where(function (Builder $query) {
                    $query->where('name', 'like', '%'.$this->search.'%');
                    $query->orWhere('email', 'like', '%'.$this->search.'%');
                });
            }
        })->relatedToUserCompany()->orderBy('name')->get();

        return view('livewire.users.index', compact(['users']));
    }
}
