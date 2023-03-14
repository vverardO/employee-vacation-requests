<?php

namespace Tests\Feature\Livewire\Roles;

use App\Http\Livewire\Roles\Edit;
use App\Models\Permission;
use App\Models\Role;
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

        $role = Role::factory()->for($user->company)->create();

        $component = Livewire::test(Edit::class, [$role->id]);

        $component->assertStatus(200);
    }

    /** @test */
    public function edit_an_role()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $role = Role::factory()->for($user->company)->create();

        $stubRole = Role::factory()->make();

        Livewire::test(Edit::class, [$role->id])
            ->set('role.title', $stubRole->title)
            ->call('store')
            ->assertSessionHas('message', 'Atualizado com sucesso!')
            ->assertSessionHas('type', 'success')
            ->assertRedirect(route('roles.index'));

        $this->assertTrue(
            Role::whereTitle($stubRole->title)
                ->exists()
        );
    }

    /** @test */
    public function edit_an_role_with_permissions()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $firstPermission = Permission::inRandomOrder()->first();
        $secondPermission = Permission::inRandomOrder()->whereNot('id', $firstPermission->id)->first();

        $role = Role::factory()->for($user->company)->create();

        $stubRole = Role::factory()->make();

        Livewire::test(Edit::class, [$role->id])
            ->set('role.title', $stubRole->title)
            ->set('rolePermissions', [$firstPermission->id, $secondPermission->id])
            ->call('store')
            ->assertSessionHas('message', 'Atualizado com sucesso!')
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
        $user = User::factory()->create();

        $this->actingAs($user);

        $role = Role::factory()->for($user->company)->create();

        Livewire::test(Edit::class, [$role->id])
            ->set('role.title', '')
            ->call('store')
            ->assertHasErrors([
                'role.title' => 'required',
            ]);
    }

    /** @test */
    public function inputs_are_maximum_size()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $title = Str::random(self::INVALID_TITLE_SIZE);

        $role = Role::factory()->for($user->company)->create();

        Livewire::test(Edit::class, [$role->id])
            ->set('role.title', $title)
            ->call('store')
            ->assertHasErrors([
                'role.title' => 'max',
            ]);
    }
}
