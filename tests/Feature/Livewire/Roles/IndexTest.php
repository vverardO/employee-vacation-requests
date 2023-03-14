<?php

namespace Tests\Feature\Livewire\Roles;

use App\Http\Livewire\Roles\Index;
use App\Models\Role;
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
    public function ensure_that_can_not_see_roles_from_another_company()
    {
        $this->actingAs(User::factory()->create());

        $usersCompanyRole = Role::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $anotherCompanyRole = Role::factory()->create();

        Livewire::test(Index::class)
            ->set('search', $usersCompanyRole->title)
            ->call('render')
            ->assertSee($usersCompanyRole->title);

        Livewire::test(Index::class)
            ->set('search', $anotherCompanyRole->title)
            ->call('render')
            ->assertDontSee($anotherCompanyRole->title);
    }

    /** @test */
    public function ensure_that_can_see_default_roles()
    {
        $role = Role::where('is_default', true)->first();

        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(Index::class)
            ->set('search', $role->title)
            ->call('render')
            ->assertSee($role->title);

        $anotherUser = User::factory()->create();
        $this->actingAs($anotherUser);

        Livewire::test(Index::class)
            ->set('search', $role->title)
            ->call('render')
            ->assertSee($role->title);
    }

    /** @test */
    public function search_for_role_title()
    {
        $this->actingAs(User::factory()->create());

        Role::factory()->create([
            'company_id' => auth()->user()->company_id,
        ]);

        $role = Role::all()->first();

        Livewire::test(Index::class)
            ->set('search', $role->title)
            ->call('render')
            ->assertSee($role->title);
    }

    /** @test */
    public function destroy_an_role_without_users()
    {
        $this->actingAs(User::factory()->create());

        $role = Role::factory([
            'company_id' => auth()->user()->company_id,
        ])->create();

        Livewire::test(Index::class)
            ->call(
                'destroy',
                $role->id
            )->assertEmitted('alert', [
                'type' => 'success',
                'message' => 'Excluído com sucesso!',
            ]);
    }

    /** @test */
    public function can_not_destroy_an_role_with_users_attached_to_it()
    {
        $this->actingAs(User::factory()->create());

        $role = Role::factory([
            'company_id' => auth()->user()->company_id,
        ])->create();

        User::factory([
            'company_id' => auth()->user()->company_id,
            'role_id' => $role->id,
        ])->create();

        Livewire::test(Index::class)
            ->call(
                'destroy',
                $role->id
            )->assertEmitted('alert', [
                'type' => 'warning',
                'message' => 'Função não pode ser excluída, existem usuários utilizando!',
            ]);
    }
}
