<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::factory()->create();

        $users = User::factory(5)->for($company)->create();

        $employees = Employee::factory(5)->for($company)->create();

        Request::factory()
            ->count(5)
            ->state(new Sequence(
                fn ($sequence) => [
                    'company_id' => $company->id,
                    'created_by' => $users->random(),
                    'employee_id' => $employees->random(),
                ],
            ))->create();
    }
}
