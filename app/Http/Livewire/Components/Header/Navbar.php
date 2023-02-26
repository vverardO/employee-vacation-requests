<?php

namespace App\Http\Livewire\Components\Header;

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
        ];
    }

    public function render()
    {
        return view('livewire.components.header.navbar', [
            'menus' => $this->menus,
        ]);
    }
}
