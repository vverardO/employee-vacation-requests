<?php

namespace Tests\Feature\Livewire\Permissions;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_not_access_users_index()
    {
        $company = Company::factory()->create();

        $user = User::factory()->for($company)->create([
            'role_id' => Role::isUser()->first()->id,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('users.index'));

        $response->assertSessionHas([
            'message' => 'Você não tem permissão!',
            'type' => 'warning',
        ]);
    }

    /** @test */
    public function admin_can_access_users_index()
    {
        $company = Company::factory()->create();

        $admin = User::factory()->for($company)->create([
            'role_id' => Role::isAdmin()->first()->id,
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('users.index'));

        $response->assertSeeInOrder([
            $admin->name,
            $admin->email,
        ]);
    }
}
