<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{
    public User $user;

    protected $rules = [
        'user.name' => ['required', 'max:128'],
        'user.email' => ['required', 'email'],
        'user.password' => ['required'],
    ];

    protected $messages = [
        'user.name.required' => 'Necessário informar o nome',
        'user.name.max' => 'Tamanho excedido',
        'user.email.required' => 'Necessário informar o email',
        'user.email.email' => 'Formato inválido',
        'user.password.required' => 'Necessário informar a senha',
    ];

    public function store()
    {
        $this->validate();

        $this->user->password = Hash::make($this->user->password);
        $this->user->status = false;
        $this->user->company_id = auth()->user()->company_id;

        $this->user->save();

        session()->flash('message', 'Cadastrado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('users.index');
    }

    public function mount()
    {
        $this->user = new User();
    }

    public function render()
    {
        return view('livewire.users.create');
    }
}
