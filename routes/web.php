<?php

use App\Livewire\Dashboard;
use App\Livewire\FormComponent;
use App\Livewire\ListComponent;
use App\Livewire\PermissionAssignScreen;
use App\Livewire\Roles;
use App\Livewire\UserForm;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Dashboard::class);
Route::get('{local}/List', ListComponent::class)->name("list.component");
Route::get('{local}/Form/{id?}', FormComponent::class)->name("form.component");
Route::get('{local}/UserForm/{id?}', UserForm::class)->name("user-form");
Route::get('{local}/ListRoles', Roles::class)->name("roles");
Route::get('PermissionAssign/{id}', PermissionAssignScreen::class)->name("permission.assign");