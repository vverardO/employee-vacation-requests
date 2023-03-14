<?php

namespace App\Http\Livewire\Roles;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
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

        session()->flash('message', 'Cadastrado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('roles.index');
    }

    public function mount()
    {
        $this->role = new Role();
    }

    public function render(): View
    {
        $permissions = Permission::select(['route_name', 'id'])->get();

        return view('livewire.roles.create', compact(['permissions']));
    }
}
