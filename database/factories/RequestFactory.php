<?php

namespace Database\Factories;

use App\Enums\RequestStatus;
use App\Models\Company;
use App\Models\Employee;
use App\Models\RequestType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestFactory extends Factory
{
    public function definition(): array
    {
        $vacationDays = random_int(5, 20);
        $days = rand(0, 180);
        $start = Carbon::today()->subDays($days)->format('Y-m-d');
        $end = Carbon::today()->subDays($days)->addDays($vacationDays)->format('Y-m-d');
        $createdAndUpdatedAt = Carbon::today()->subDays(rand(0, 40));
        $approved = fake()->boolean();
        $open = fake()->boolean(33);

        if ($approved) {
            $approvedBy = User::inRandomOrder()->first()->id;
            $approvedAt = Carbon::now();
            $rejectedBy = null;
            $rejectedAt = null;
            $status = RequestStatus::Approved;
        } else {
            $approvedBy = null;
            $approvedAt = null;
            $rejectedBy = User::inRandomOrder()->first()->id;
            $rejectedAt = Carbon::now();
            $status = RequestStatus::Rejected;
        }

        if ($open) {
            $approvedBy = null;
            $approvedAt = null;
            $rejectedBy = null;
            $rejectedAt = null;
            $status = RequestStatus::Opened;
        }

        return [
            'number' => fake()->unique()->randomNumber(3),
            'title' => fake()->name(),
            'start' => $start,
            'end' => $end,
            'status' => $status,
            'approved_at' => $approvedAt,
            'approved_by' => $approvedBy,
            'rejected_at' => $rejectedAt,
            'rejected_by' => $rejectedBy,
            'created_by' => User::factory(),
            'company_id' => Company::factory(),
            'employee_id' => Employee::factory(),
            'request_type_id' => RequestType::inRandomOrder()->first()->id,
            'created_at' => $createdAndUpdatedAt,
            'updated_at' => $createdAndUpdatedAt,
        ];
    }
}
