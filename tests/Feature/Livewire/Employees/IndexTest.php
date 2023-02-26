<?php

namespace Tests\Feature\Livewire\Employees;

use App\Http\Livewire\Employees\Index;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render()
    {
        $this->actingAs(User::factory()->create());

        $component = Livewire::test(Index::class);

        $component->assertStatus(200);
    }

    /** @test */
    public function search_for_employee_registration_physical_person()
    {
        $this->actingAs(User::factory()->create());

        Employee::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $employee = Employee::all()->first();

        Livewire::test(Index::class)
            ->set('search', $employee->registration_physical_person)
            ->call('render')
            ->assertSee($employee->registration_physical_person);
    }

    /** @test */
    public function search_for_employee_general_record()
    {
        $this->actingAs(User::factory()->create());

        Employee::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $employee = Employee::all()->first();

        Livewire::test(Index::class)
            ->set('search', $employee->general_record)
            ->call('render')
            ->assertSee($employee->general_record);
    }

    /** @test */
    public function search_for_employee_name()
    {
        $this->actingAs(User::factory()->create());

        Employee::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $employee = Employee::all()->first();

        Livewire::test(Index::class)
            ->set('search', $employee->name)
            ->call('render')
            ->assertSee($employee->name);
    }

    /** @test */
    public function destroy_an_employee()
    {
        $this->actingAs(User::factory()->create());

        $employee = Employee::factory()->create();

        Livewire::test(Index::class)
            ->call(
                'destroy',
                'Employee',
                $employee->id
            )->assertEmitted('alert', [
                'type' => 'success',
                'message' => 'Excluído com sucesso!',
            ]);
    }
}
