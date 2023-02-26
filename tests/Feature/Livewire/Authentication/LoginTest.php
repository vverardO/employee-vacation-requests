<?php

namespace Tests\Feature\Livewire\Authentication;

use App\Http\Livewire\Authentication\Login;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Login::class);

        $component->assertStatus(200);
    }

    /** @test */
    public function the_user_can_login()
    {
        $company = Company::factory()->create([
            'name' => 'company name',
            'identificator' => '78.118.120/0001-85',
        ]);

        User::factory()->create([
            'name' => 'user name',
            'email' => 'user@name.com',
            'company_id' => $company->id,
        ]);

        Livewire::test(Login::class)
            ->set('email', 'user@name.com')
            ->set('password', 'password') // used in UserFactory
            ->call('login')
            ->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function email_and_password_are_required()
    {
        Livewire::test(Login::class)
            ->call('login')
            ->assertHasErrors([
                'email' => 'required',
                'password' => 'required',
            ]);
    }

    /** @test */
    public function email_dont_exists()
    {
        Livewire::test(Login::class)
            ->set('email', 'user@name.com')
            ->call('login')
            ->assertHasErrors([
                'email' => 'exists',
            ]);
    }

    /** @test */
    public function email_or_password_are_invalid()
    {
        $company = Company::factory()->create([
            'name' => 'company name',
            'identificator' => '78.118.120/0001-85',
        ]);

        User::factory()->create([
            'name' => 'user name',
            'email' => 'user@name.com',
            'company_id' => $company->id,
        ]);

        Livewire::test(Login::class)
            ->set('email', 'user@name.com')
            ->set('password', 'passw0rd')
            ->call('login')
            ->assertHasErrors([
                'email',
            ]);
    }
}
