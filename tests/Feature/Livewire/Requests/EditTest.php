<?php

namespace Tests\Feature\Livewire\Requests;

use App\Http\Livewire\Requests\Edit;
use App\Models\Employee;
use App\Models\Request;
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

        $request = Request::factory()->for($user->company)->create();

        $component = Livewire::test(Edit::class, [$request->id]);

        $component->assertStatus(200);
    }

    /** @test */
    public function edit_an_request()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $request = Request::factory()->create([
            'company_id' => auth()->user()->company_id,
            'created_by' => auth()->user()->id,
        ]);

        $stubRequest = Request::factory()->make();

        $stubEmployee = Employee::factory()->for($user->company)->create();

        Livewire::test(Edit::class, [$request->id])
            ->set('request.title', $stubRequest->title)
            ->set('request.start', $stubRequest->start)
            ->set('request.end', $stubRequest->end)
            ->set('request.employee_id', $stubEmployee->id)
            ->set('request.request_type_id', $stubRequest->request_type_id)
            ->call('store')
            ->assertSessionHas('message', 'Atualizado com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('requests.index'));

        $this->assertTrue(
            Request::whereTitle($stubRequest->title)
                ->whereEmployeeId($stubEmployee->id)
                ->whereRequestTypeId($stubRequest->request_type_id)
                ->whereStart($stubRequest->start)
                ->whereEnd($stubRequest->end)
                ->exists()
        );
    }

    /** @test */
    public function inputs_are_required()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $request = Request::factory()->create([
            'company_id' => auth()->user()->company_id,
            'created_by' => auth()->user()->id,
        ]);

        Livewire::test(Edit::class, [$request->id])
            ->set('request.title', '')
            ->set('request.start', '')
            ->set('request.end', '')
            ->set('request.employee_id', null)
            ->set('request.request_type_id', null)
            ->call('store')
            ->assertHasErrors([
                'request.title' => 'required',
                'request.start' => 'required',
                'request.end' => 'required',
                'request.employee_id' => 'required',
                'request.request_type_id' => 'required',
            ]);
    }

    /** @test */
    public function inputs_are_maximum_size()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $title = Str::random(self::INVALID_TITLE_SIZE);

        $request = Request::factory()->create([
            'company_id' => auth()->user()->company_id,
            'created_by' => auth()->user()->id,
        ]);

        Livewire::test(Edit::class, [$request->id])
            ->set('request.title', $title)
            ->call('store')
            ->assertHasErrors([
                'request.title' => 'max',
            ]);
    }
}
