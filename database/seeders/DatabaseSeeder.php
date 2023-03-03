<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Request;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Company::factory(5)
            ->hasUsers(3)
            ->hasEmployees(5)
            ->create()
            ->each(function ($company) {
                $user = User::where('company_id', $company->id)->first();

                Request::factory(5, [
                    'created_by' => $user->id,
                ])->for($company)
                    ->create();
            });
    }
}
