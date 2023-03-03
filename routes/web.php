<?php

use App\Http\Livewire\Authentication\Login;
use App\Http\Livewire\Authentication\Register;
use App\Http\Livewire\Companies\Edit as CompaniesEdit;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Employees\Create as EmployeesCreate;
use App\Http\Livewire\Employees\Edit as EmployeesEdit;
use App\Http\Livewire\Employees\Index as EmployeesIndex;
use App\Http\Livewire\Requests\Create as RequestsCreate;
use App\Http\Livewire\Requests\Edit as RequestsEdit;
use App\Http\Livewire\Requests\Index as RequestsIndex;
use App\Http\Livewire\Users\Create as UsersCreate;
use App\Http\Livewire\Users\Edit as UsersEdit;
use App\Http\Livewire\Users\Index as UsersIndex;
use App\Http\Livewire\Users\Profile as UsersProfile;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::get('/profile', UsersProfile::class)->name('profile');
    Route::get('/company', CompaniesEdit::class)->name('company');

    Route::prefix('users')->group(function () {
        Route::get('/', UsersIndex::class)->name('users.index');
        Route::get('/create', UsersCreate::class)->name('users.create');
        Route::get('/edit/{id}', UsersEdit::class)->name('users.edit');
    });

    Route::prefix('employees')->group(function () {
        Route::get('/', EmployeesIndex::class)->name('employees.index');
        Route::get('/create', EmployeesCreate::class)->name('employees.create');
        Route::get('/edit/{id}', EmployeesEdit::class)->name('employees.edit');
    });

    Route::prefix('requests')->group(function () {
        Route::get('/', RequestsIndex::class)->name('requests.index');
        Route::get('/create', RequestsCreate::class)->name('requests.create');
        Route::get('/edit/{id}', RequestsEdit::class)->name('requests.edit');
    });
});
