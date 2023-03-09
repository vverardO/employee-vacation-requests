<?php

namespace App\Http\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Edit extends Component
{
    public User $user;

    public Collection $roles;

    protected $rules = [
        'user.name' => ['required', 'max:128'],
        'user.email' => ['required', 'email'],
        'user.password' => ['sometimes'],
        'user.company.name' => ['sometimes'],
        'user.role_id' => ['required'],
    ];

    protected $messages = [
        'user.name.required' => 'Necessário informar o nome',
        'user.name.max' => 'Tamanho excedido',
        'user.email.required' => 'Necessário informar o email',
        'user.email.email' => 'Formato inválido',
        'user.password.sometimes' => 'Necessário informar a senha',
        'user.role_id' => 'Selecione o perfil',
    ];

    public function store()
    {
        $this->validate();

        if ($this->user->password) {
            $this->user->password = Hash::make($this->user->password);
        } else {
            unset($this->user->password);
        }

        $this->user->save();

        session()->flash('message', 'Atualizado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('users.index');
    }

    public function mount($id)
    {
        try {
            $this->user = User::with([
                'company',
            ])->relatedToUserCompany()->findOrFail($id)->makeHidden('password');
        } catch (ModelNotFoundException $exception) {
            session()->flash('message', 'Usuário inválido!');
            session()->flash('type', 'warning');

            return redirect()->route('users.index');
        }

        $this->roles = Role::select(['title', 'id'])->get();
    }

    public function render()
    {
        return view('livewire.users.edit');
    }
}
