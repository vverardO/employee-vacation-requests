<?php

namespace App\Http\Livewire\Roles;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class Edit extends Component
{
    public Role $role;

    public array $rolePermissions = [];

    protected $rules = [
        'role.title' => ['required', 'max:128'],
    ];

    protected $messages = [
        'role.title.required' => 'Informe o título',
        'role.title.max' => 'Tamanho excedido',
    ];

    public function store()
    {
        $this->validate();

        $this->role->is_default = false;
        $this->role->company_id = auth()->user()->company_id;

        $this->role->save();

        if ($this->rolePermissions) {
            $this->role->permissions()->sync($this->rolePermissions);
        }

        session()->flash('message', 'Atualizado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('roles.index');
    }

    public function mount($id)
    {
        try {
            $this->role = Role::with([
                'permissions',
            ])->relatedToUserCompany()
                ->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            session()->flash('message', 'Função inválida ou padrão (não pode ser atualizada)');
            session()->flash('type', 'warning');

            return redirect()->route('roles.index');
        }

        $this->rolePermissions = $this->role->permissions->pluck('id')->map(function ($item) {
            return (string) $item;
        })->toArray();
    }

    public function render()
    {
        $permissions = Permission::select(['route_name', 'id'])->get();

        return view('livewire.roles.edit', compact(['permissions']));
    }
}
