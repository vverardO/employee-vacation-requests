<?php

namespace Tests\Feature\Livewire\Permissions;

use App\Http\Livewire\Requests\Create;
use App\Http\Livewire\Requests\Index;
use App\Models\Company;
use App\Models\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class RequestsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_not_edit_request_from_another_company()
    {
        $companyOne = Company::factory()->create();
        $userFromCompanyOne = User::factory()->for($companyOne)->create();

        $companyTwo = Company::factory()->create();
        $userFromCompanyTwo = User::factory()->for($companyTwo)->create();

        $this->actingAs($userFromCompanyOne);

        $request = Request::factory()->create([
            'company_id' => auth()->user()->company_id,
            'created_by' => auth()->user()->id,
        ]);

        $this->assertTrue(
            Request::whereTitle($request->title)
                ->whereEmployeeId($request->employee_id)
                ->whereCompanyId(auth()->user()->company_id)
                ->whereCreatedBy(auth()->user()->id)
                ->exists()
        );

        $this->assertFalse(
            Request::whereTitle($request->title)
                ->whereEmployeeId($request->employee_id)
                ->whereCompanyId($companyTwo->id)
                ->whereCreatedBy($userFromCompanyTwo->id)
                ->exists()
        );
    }

    /** @test */
    public function user_can_not_see_request_from_another_company()
    {
        $companyOne = Company::factory()->create();
        $userFromCompanyOne = User::factory()->for($companyOne)->create();

        $companyTwo = Company::factory()->create();
        $userFromCompanyTwo = User::factory()->for($companyTwo)->create();

        $this->actingAs($userFromCompanyOne);

        $requestFromCompanyOne = Request::factory()->create([
            'title' => 'request from company one',
            'company_id' => auth()->user()->company_id,
            'created_by' => auth()->user()->id,
        ]);

        $requestFromCompanyTwo = Request::factory()->create([
            'title' => 'request from company two',
            'company_id' => $companyTwo->id,
            'created_by' => $userFromCompanyTwo->id,
        ]);

        Livewire::test(Index::class)
            ->set('search', $requestFromCompanyOne->title)
            ->call('render')
            ->assertSee($requestFromCompanyOne->title);

        Livewire::test(Index::class)
            ->set('search', $requestFromCompanyTwo->title)
            ->call('render')
            ->assertDontSee($requestFromCompanyTwo->title);
    }

    /** @test */
    public function ensure_that_user_can_not_create_request_on_another_company()
    {
        $companyOne = Company::factory()->create();
        $userFromCompanyOne = User::factory()->for($companyOne)->create();

        $companyTwo = Company::factory()->create();

        $this->actingAs($userFromCompanyOne);

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
                ->whereCompanyId($companyOne->id)
                ->whereRequestTypeId($stubRequest->requestType->id)
                ->whereStart($stubRequest->start)
                ->whereEnd($stubRequest->end)
                ->exists()
        );

        $this->assertFalse(
            Request::whereTitle($stubRequest->title)
                ->whereEmployeeId($stubRequest->employee->id)
                ->whereCompanyId($companyTwo->id)
                ->whereRequestTypeId($stubRequest->requestType->id)
                ->whereStart($stubRequest->start)
                ->whereEnd($stubRequest->end)
                ->exists()
        );
    }
    
    /** @test */
    public function user_can_see_only_request_created_by_him()
    {
        $company = Company::factory()->create();
        
        $user = User::factory()->for($company)->create([
            'role_id' => Role::isUser()->first()->id,
        ]);

        $anotherUser = User::factory()->for($company)->create([
            'role_id' => Role::isUser()->first()->id,
        ]);

        $this->actingAs($user);

        $requestCreatedByUser = Request::factory()->for($company)->create([
            'title' => 'request from user',
            'created_by' => auth()->user()->id,
        ]);

        $requestCreatedByAnotherUser = Request::factory()->for($company)->create([
            'title' => 'request from another user',
            'created_by' => $anotherUser->id,
        ]);

        Livewire::test(Index::class)
            ->set('search', $requestCreatedByUser->title)
            ->call('render')
            ->assertSee($requestCreatedByUser->title);

        Livewire::test(Index::class)
            ->set('search', $requestCreatedByAnotherUser->title)
            ->call('render')
            ->assertDontSee($requestCreatedByAnotherUser->title);
    }

    /** @test */
    public function admin_can_see_all_requests()
    {
        $company = Company::factory()->create();
        
        $admin = User::factory()->for($company)->create([
            'role_id' => Role::isAdmin()->first()->id,
        ]);

        $user = User::factory()->for($company)->create([
            'role_id' => Role::isUser()->first()->id,
        ]);

        $anotherUser = User::factory()->for($company)->create([
            'role_id' => Role::isUser()->first()->id,
        ]);

        $this->actingAs($admin);

        $requestCreatedByAdmin = Request::factory()->for($company)->create([
            'title' => 'request from admin',
            'created_by' => auth()->user()->id,
        ]);

        $requestCreatedByUser = Request::factory()->for($company)->create([
            'title' => 'request from user',
            'created_by' => $user->id,
        ]);

        $requestCreatedByAnotherUser = Request::factory()->for($company)->create([
            'title' => 'request from another user',
            'created_by' => $anotherUser->id,
        ]);

        Livewire::test(Index::class)
            ->set('search', $requestCreatedByUser->title)
            ->call('render')
            ->assertSee($requestCreatedByUser->title);

        Livewire::test(Index::class)
            ->set('search', $requestCreatedByAnotherUser->title)
            ->call('render')
            ->assertSee($requestCreatedByAnotherUser->title);

        Livewire::test(Index::class)
            ->set('search', $requestCreatedByAdmin->title)
            ->call('render')
            ->assertSee($requestCreatedByAdmin->title);
    }
}
