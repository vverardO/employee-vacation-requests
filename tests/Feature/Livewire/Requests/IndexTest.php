<?php

namespace Tests\Feature\Livewire\Requests;

use App\Http\Livewire\Requests\Index;
use App\Models\Request;
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
    public function search_for_request_title()
    {
        $this->actingAs(User::factory()->create());

        Request::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $request = Request::all()->first();

        Livewire::test(Index::class)
            ->set('search', $request->title)
            ->call('render')
            ->assertSee($request->title);
    }

    /** @test */
    public function search_for_request_number()
    {
        $this->actingAs(User::factory()->create());

        Request::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $request = Request::all()->first();

        Livewire::test(Index::class)
            ->set('search', $request->number)
            ->call('render')
            ->assertSee($request->number);
    }

    /** @test */
    public function search_for_request_type()
    {
        $this->actingAs(User::factory()->create());

        Request::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $request = Request::all()->first();

        Livewire::test(Index::class)
            ->set('search', $request->requestType->title)
            ->call('render')
            ->assertSee($request->requestType->title);
    }

    /** @test */
    public function search_for_request_employee()
    {
        $this->actingAs(User::factory()->create());

        Request::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $request = Request::all()->first();

        Livewire::test(Index::class)
            ->set('search', $request->employee->name)
            ->call('render')
            ->assertSee($request->employee->name);
    }

    /** @test */
    public function destroy_an_request()
    {
        $this->actingAs(User::factory()->create());

        $request = Request::factory()->create();

        Livewire::test(Index::class)
            ->call(
                'destroy',
                'Request',
                $request->id
            )->assertEmitted('alert', [
                'type' => 'success',
                'message' => 'Excluído com sucesso!',
            ]);
    }
}
