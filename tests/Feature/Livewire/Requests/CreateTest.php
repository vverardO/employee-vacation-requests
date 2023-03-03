<?php

namespace Tests\Feature\Livewire\Requests;

use App\Http\Livewire\Requests\Create;
use App\Models\Request;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render()
    {
        $this->actingAs(User::factory()->create());

        $component = Livewire::test(Create::class);

        $component->assertStatus(200);
    }

    /** @test */
    public function create_an_request()
    {
        $this->actingAs(User::factory()->create());

        $stubRequest = Request::factory()->make();

        Livewire::test(Create::class)
            ->set('request.title', $stubRequest->title)
            ->set('request.start', $stubRequest->start)
            ->set('request.end', $stubRequest->end)
            ->set('request.employee_id', $stubRequest->employee_id)
            ->set('request.request_type_id', $stubRequest->request_type_id)
            ->call('store')
            ->assertSessionHas('message', 'Cadastrado com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('requests.index'));

        $this->assertTrue(
            Request::whereTitle($stubRequest->title)
                ->whereEmployeeId($stubRequest->employee->id)
                ->whereRequestTypeId($stubRequest->requestType->id)
                ->whereStart($stubRequest->start)
                ->whereEnd($stubRequest->end)
                ->exists()
        );
    }

    /** @test */
    public function inputs_are_required()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Create::class)
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
        $this->actingAs(User::factory()->create());

        $title = Str::random(self::INVALID_TITLE_SIZE);

        Livewire::test(Create::class)
            ->set('request.title', $title)
            ->call('store')
            ->assertHasErrors([
                'request.title' => 'max',
            ]);
    }
}
