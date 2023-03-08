<?php

namespace App\Http\Livewire\Components\Header;

use App\Models\Role;
use Livewire\Component;

class Navbar extends Component
{
    protected array $menus;

    public function mount()
    {
        $this->menus = [
            'users' => [
                'title' => 'Usuários',
                'icon' => 'fas fa-users-cog',
                'route' => route('users.index'),
                'active' => request()->routeIs('users.*') ? 'active' : '',
            ],
            'employees' => [
                'title' => 'Funcionários',
                'icon' => 'fas fa-users',
                'route' => route('employees.index'),
                'active' => request()->routeIs('employees.*') ? 'active' : '',
            ],
            'requests' => [
                'title' => 'Solicitações',
                'icon' => 'fas fa-calendar-alt',
                'route' => route('requests.index'),
                'active' => request()->routeIs('requests.*') ? 'active' : '',
            ],
        ];

        if (Role::USER == auth()->user()->role->title) {
            unset($this->menus['users']);
        }
    }

    public function render()
    {
        return view('livewire.components.header.navbar', [
            'menus' => $this->menus,
        ]);
    }
}
