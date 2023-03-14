<?php

namespace App\Http\Livewire\Employees;

use App\Enums\GendersEnum;
use App\Models\Employee;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class Edit extends Component
{
    public Employee $employee;

    public array $genders;

    protected $rules = [
        'employee.name' => ['required', 'max:128'],
        'employee.gender' => ['required'],
        'employee.general_record' => ['required', 'digits:10'],
        'employee.registration_physical_person' => ['required', 'size:14'],
    ];

    protected $messages = [
        'employee.name.required' => 'Informe o nome',
        'employee.name.max' => 'Tamanho excedido',
        'employee.gender.required' => 'Selecione o gênero',
        'employee.general_record.required' => 'Informe o RG',
        'employee.general_record.digits' => 'O RG precisa ter 10 digitos e ser numérico',
        'employee.registration_physical_person.required' => 'Informe o CPF',
        'employee.registration_physical_person.size' => 'O CPF precisa ter 14 dígitos (formatado)',
    ];

    public function store()
    {
        $this->validate();

        $this->employee->company_id = auth()->user()->company_id;

        $this->employee->save();

        session()->flash('message', 'Atualizado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('employees.index');
    }

    public function mount($id)
    {
        try {
            $this->employee = Employee::relatedToUserCompany()->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            session()->flash('message', 'Funcionário inválido!');
            session()->flash('type', 'warning');

            return redirect()->route('employees.index');
        }

        collect(GendersEnum::cases())->each(function (GendersEnum $gender) {
            $this->genders[$gender->value] = $gender->getName($gender->value);
        });
    }

    public function render()
    {
        return view('livewire.employees.edit');
    }
}
