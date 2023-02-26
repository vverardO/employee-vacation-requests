<?php

namespace App\Http\Livewire\Employees;

use App\Models\Employee;
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

    public function mount()
    {
        $this->fill(request()->only('search'));
    }

    public function render()
    {
        $employees = Employee::where(function (Builder $builder) {
            if ($this->search) {
                $builder->where(function (Builder $query) {
                    $query->where('name', 'like', '%'.$this->search.'%');
                    $query->orWhere('general_record', 'like', '%'.$this->search.'%');
                    $query->orWhere('registration_physical_person', 'like', '%'.$this->search.'%');
                });
            }
        })->relatedToUserCompany()->orderBy('name')->get();

        return view('livewire.employees.index', compact(['employees']));
    }
}
