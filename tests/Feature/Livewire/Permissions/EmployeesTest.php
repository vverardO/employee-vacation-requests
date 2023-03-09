<?php

namespace Tests\Feature\Livewire\Permissions;

use App\Http\Livewire\Employees\Create;
use App\Http\Livewire\Employees\Index;
use App\Http\Livewire\Employees\Edit;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class EmployeesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_not_edit_employee_from_another_company()
    {
        $companyOne = Company::factory()->create();
        $userFromCompanyOne = User::factory()->for($companyOne)->create();

        $companyTwo = Company::factory()->create();

        $this->actingAs($userFromCompanyOne);

        $employeeFromCompanyTwo = Employee::factory()->for($companyTwo)->create();

        Livewire::test(Edit::class, [$employeeFromCompanyTwo->id])
            ->assertSessionHas('message', 'Funcionário inválido!')
            ->assertSessionHas('type', 'warning')
            ->assertRedirect(route('employees.index'));
    }

    /** @test */
    public function user_can_not_see_employee_from_another_company()
    {
        $companyOne = Company::factory()->create();
        $userFromCompanyOne = User::factory()->for($companyOne)->create();

        $companyTwo = Company::factory()->create();

        $this->actingAs($userFromCompanyOne);

        $requestFromCompanyOne = Employee::factory()->create([
            'name' => 'employee from company one',
            'company_id' => auth()->user()->company_id,
        ]);

        $requestFromCompanyTwo = Employee::factory()->create([
            'name' => 'employee from company two',
            'company_id' => $companyTwo->id,
        ]);

        Livewire::test(Index::class)
            ->set('search', $requestFromCompanyOne->name)
            ->call('render')
            ->assertSee($requestFromCompanyOne->name);

        Livewire::test(Index::class)
            ->set('search', $requestFromCompanyTwo->name)
            ->call('render')
            ->assertDontSee($requestFromCompanyTwo->name);
    }

    /** @test */
    public function ensure_that_user_can_not_create_employee_on_another_company()
    {
        $companyOne = Company::factory()->create();
        $userFromCompanyOne = User::factory()->for($companyOne)->create();

        $companyTwo = Company::factory()->create();

        $this->actingAs($userFromCompanyOne);

        $stubEmployee = Employee::factory()->make();

        Livewire::test(Create::class)
            ->set('employee.name', $stubEmployee->name)
            ->set('employee.gender', $stubEmployee->gender)
            ->set('employee.general_record', $stubEmployee->general_record)
            ->set('employee.registration_physical_person', $stubEmployee->registration_physical_person)
            ->call('store')
            ->assertSessionHas('message', 'Cadastrado com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('employees.index'));

        $this->assertTrue(
            Employee::whereName($stubEmployee->name)
                ->whereGender($stubEmployee->gender)
                ->whereCompanyId($companyOne->id)
                ->whereGeneralRecord($stubEmployee->general_record)
                ->whereRegistrationPhysicalPerson($stubEmployee->registration_physical_person)
                ->exists()
        );

        $this->assertFalse(
            Employee::whereName($stubEmployee->name)
                ->whereGender($stubEmployee->gender)
                ->whereCompanyId($companyTwo->id)
                ->whereGeneralRecord($stubEmployee->general_record)
                ->whereRegistrationPhysicalPerson($stubEmployee->registration_physical_person)
                ->exists()
        );
    }
}
