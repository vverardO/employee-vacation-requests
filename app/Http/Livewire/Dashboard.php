<?php

namespace App\Http\Livewire;

use App\Enums\RequestStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $lastWeekStartAt = Carbon::now()->startOfWeek();
        $lastWeekEndAt = Carbon::now()->endOfWeek();

        $weekRequests = DB::table('requests')
            ->where('company_id', auth()->user()->company_id)
            ->whereBetween('created_at', [
                $lastWeekStartAt,
                $lastWeekEndAt,
            ])->count();

        $requestsToAvaliate = DB::table('requests')
            ->where('company_id', auth()->user()->company_id)
            ->where('status', [
                RequestStatus::Opened,
            ])->count();

        $requestsToAvaliated = DB::table('requests')
            ->where('company_id', auth()->user()->company_id)
            ->where('status', [
                RequestStatus::Rejected,
                RequestStatus::Approved,
            ])->count();

        $employeesCreated = DB::table('employees')
            ->where('company_id', auth()->user()->company_id)
            ->whereBetween('created_at', [
                $lastWeekStartAt,
                $lastWeekEndAt,
            ])->count();

        return view('livewire.dashboard', compact([
            'weekRequests',
            'requestsToAvaliate',
            'requestsToAvaliated',
            'employeesCreated',
        ]));
    }
}
