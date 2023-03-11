<?php

namespace App\Http\Livewire\Requests;

use App\Enums\RequestStatus;
use App\Models\Request;
use App\Traits\Destroyable;
use App\Traits\Showable;
use Carbon\Carbon;
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

    public function approve($id)
    {
        $request = Request::find($id);

        $request->update([
            'approved_by' => auth()->user()->id,
            'approved_at' => Carbon::now(),
            'status' => RequestStatus::Approved,
        ]);

        $request->save();

        $this->emit('alert', [
            'type' => 'success',
            'message' => 'Solicitação aprovada com sucesso!',
        ]);
    }

    public function reject($id)
    {
        $request = Request::find($id);

        $request->update([
            'rejected_by' => auth()->user()->id,
            'rejected_at' => Carbon::now(),
            'status' => RequestStatus::Rejected,
        ]);

        $request->save();

        $this->emit('alert', [
            'type' => 'success',
            'message' => 'Solicitação rejeitada com sucesso!',
        ]);
    }

    public function notify()
    {
        $this->emit('alert', [
            'type' => 'warning',
            'message' => 'Apenas solicitações em aberto podem ser editadas!',
        ]);
    }

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
