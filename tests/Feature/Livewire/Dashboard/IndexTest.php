<?php

namespace Tests\Feature\Livewire\Dashboard;

use App\Http\Livewire\Dashboard;
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

        $component = Livewire::test(Dashboard::class);

        $component->assertStatus(200);
    }
}
