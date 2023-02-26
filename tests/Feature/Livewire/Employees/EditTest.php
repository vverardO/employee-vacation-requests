<?php

namespace Tests\Feature\Livewire\Employees;

use App\Http\Livewire\Employees\Edit;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $employee = Employee::factory()->for($user->company)->create();

        $component = Livewire::test(Edit::class, [$employee->id]);

        $component->assertStatus(200);
    }

    /** @test */
    public function edit_an_employee()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $employee = Employee::factory()->for($user->company)->create();

        $stubEmployee = Employee::factory()->make();

        Livewire::test(Edit::class, [$employee->id])
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
                ->whereGeneralRecord($stubEmployee->general_record)
                ->whereRegistrationPhysicalPerson($stubEmployee->registration_physical_person)
                ->exists()
        );
    }

    /** @test */
    public function inputs_are_required()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $employee = Employee::factory()->for($user->company)->create();

        Livewire::test(Edit::class, [$employee->id])
            ->set('employee.name', '')
            ->set('employee.gender', null)
            ->set('employee.general_record', '')
            ->set('employee.registration_physical_person', '')
            ->call('store')
            ->assertHasErrors([
                'employee.name' => 'required',
                'employee.gender' => 'required',
                'employee.general_record' => 'required',
                'employee.registration_physical_person' => 'required',
            ]);
    }

    /** @test */
    public function inputs_are_maximum_size()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $name = Str::random(self::INVALID_NAME_SIZE);
        $generalRecord = Str::random(self::INVALID_GENERAL_RECORD_SIZE);
        $registrationPhysicalPerson = Str::random(self::INVALID_REGISTRATION_PHYSICAL_PERSON_SIZE);

        $employee = Employee::factory()->for($user->company)->create();

        Livewire::test(Edit::class, [$employee->id])
            ->set('employee.name', $name)
            ->set('employee.general_record', $generalRecord)
            ->set('employee.registration_physical_person', $registrationPhysicalPerson)
            ->call('store')
            ->assertHasErrors([
                'employee.name' => 'max',
                'employee.general_record' => 'digits',
                'employee.registration_physical_person' => 'size',
            ]);
    }
}
