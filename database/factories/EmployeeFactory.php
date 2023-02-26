<?php

namespace Database\Factories;

use App\Enums\GendersEnum;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        $gender = fake()->boolean() ? GendersEnum::Male : GendersEnum::Female;
        $createdAndUpdatedAt = Carbon::now();

        [
            $one,
            $two,
            $three,
            $four,
        ] = [
            substr(str_shuffle('0123456789'), 0, 3),
            substr(str_shuffle('0123456789'), 0, 3),
            substr(str_shuffle('0123456789'), 0, 3),
            substr(str_shuffle('0123456789'), 0, 2),
        ];

        $document = str_shuffle('0123456789');

        return [
            'name' => fake()->unique()->name(),
            'gender' => $gender,
            'general_record' => $document,
            'registration_physical_person' => "$one.$two.$three-$four",
            'company_id' => Company::factory(),
            'created_at' => $createdAndUpdatedAt,
            'updated_at' => $createdAndUpdatedAt,
        ];
    }
}
