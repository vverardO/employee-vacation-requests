<?php

namespace Tests\Feature\Livewire\Roles;

use App\Http\Livewire\Roles\Create;
use App\Models\Permission;
use App\Models\Role;
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
    public function create_an_role()
    {
        $this->actingAs(User::factory()->create());

        $stubRole = Role::factory()->make();

        Livewire::test(Create::class)
            ->set('role.title', $stubRole->title)
            ->call('store')
            ->assertSessionHas('message', 'Cadastrado com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('roles.index'));

        $this->assertTrue(
            Role::whereTitle($stubRole->title)
                ->exists()
        );
    }

    /** @test */
    public function create_an_role_with_permissions()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $stubRole = Role::factory()->for($user->company)->make();

        $firstPermission = Permission::inRandomOrder()->first();
        $secondPermission = Permission::inRandomOrder()->whereNot('id', $firstPermission->id)->first();

        Livewire::test(Create::class)
            ->set('role.title', $stubRole->title)
            ->set('rolePermissions', [$firstPermission->id, $secondPermission->id])
            ->call('store')
            ->assertSessionHas('message', 'Cadastrado com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('roles.index'));

        $this->assertTrue(Role::whereTitle($stubRole->title)->exists());

        $this->assertTrue(
            Role::whereRelation(
                'permissions',
                'permission_id',
                $firstPermission->id
            )->exists()
        );

        $this->assertTrue(
            Role::whereRelation(
                'permissions',
                'permission_id',
                $secondPermission->id
            )->exists()
        );
    }

    /** @test */
    public function inputs_are_required()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Create::class)
            ->set('role.title', '')
            ->call('store')
            ->assertHasErrors([
                'role.title' => 'required',
            ]);
    }

    /** @test */
    public function inputs_are_maximum_size()
    {
        $this->actingAs(User::factory()->create());

        $title = Str::random(self::INVALID_TITLE_SIZE);

        Livewire::test(Create::class)
            ->set('role.title', $title)
            ->call('store')
            ->assertHasErrors([
                'role.title' => 'max',
            ]);
    }
}
