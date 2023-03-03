<?php

namespace App\Http\Livewire\Requests;

use App\Models\Request;
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
        $requests = Request::with(['requestType', 'employee'])->where(function (Builder $builder) {
            if ($this->search) {
                $builder->where(function (Builder $query) {
                    $query->where('number', 'like', '%'.$this->search.'%');
                    $query->orWhere('title', 'like', '%'.$this->search.'%');
                    $query->orWhere('start', 'like', '%'.$this->search.'%');
                    $query->orWhere('end', 'like', '%'.$this->search.'%');
                    $query->orWhereRelation('employee', 'name', 'like', '%'.$this->search.'%');
                    $query->orWhereRelation('requestType', 'title', 'like', '%'.$this->search.'%');
                });
            }
        })->relatedToUserCompany()
            ->relatedToUser()
            ->orderBy('number')
            ->get();

        return view('livewire.requests.index', compact(['requests']));
    }
}
