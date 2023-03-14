<?php

namespace Tests\Feature\Livewire\Permissions;

use App\Http\Livewire\Permissions\Index;
use App\Models\Permission;
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
    public function search_for_permission_route_title()
    {
        $this->actingAs(User::factory()->create());

        $permission = Permission::all()->first();

        Livewire::test(Index::class)
            ->set('search', $permission->route_title)
            ->call('render')
            ->assertSee($permission->route_title);
    }

    /** @test */
    public function search_for_permission_route_name()
    {
        $this->actingAs(User::factory()->create());

        $permission = Permission::all()->first();

        Livewire::test(Index::class)
            ->set('search', $permission->route_name)
            ->call('render')
            ->assertSee($permission->route_name);
    }
}
