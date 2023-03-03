<?php

namespace App\Http\Livewire\Requests;

use App\Enums\RequestStatus;
use App\Models\Employee;
use App\Models\Request;
use App\Models\RequestType;
use Illuminate\Support\Collection;
use Livewire\Component;

class Create extends Component
{
    public Request $request;

    public Collection $employees;

    public Collection $requestTypes;

    public array $genders;

    protected $rules = [
        'request.title' => ['required', 'max:128'],
        'request.start' => ['required'],
        'request.end' => ['required'],
        'request.employee_id' => ['required'],
        'request.request_type_id' => ['required'],
    ];

    protected $messages = [
        'request.title.required' => 'Informe o título',
        'request.title.max' => 'Tamanho excedido',
        'request.start.required' => 'Informe a data inicial',
        'request.end.required' => 'Informe a data final',
        'request.employee_id.required' => 'Selecione o funcionário',
        'request.request_type_id.required' => 'Selecione o tipo',
    ];

    public function store()
    {
        $this->validate();

        $requestsQuantity = Request::relatedToUserCompany()->count();
        $this->request->number = ++$requestsQuantity;
        $this->request->company_id = auth()->user()->company_id;
        $this->request->created_by = auth()->user()->id;
        $this->request->status = RequestStatus::Opened;

        $this->request->save();

        session()->flash('message', 'Cadastrado com sucesso!');
        session()->flash('type', 'success');

        return redirect()->route('requests.index');
    }

    public function mount()
    {
        $this->request = new Request();
        $this->employees = Employee::relatedToUserCompany()->select(['name', 'id'])->get();
        $this->requestTypes = RequestType::select(['title', 'id'])->get();
    }

    public function render()
    {
        return view('livewire.requests.create');
    }
}
