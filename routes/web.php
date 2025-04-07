<?php

use App\Livewire\Dashboard;
use App\Livewire\ProfileScreen;
use App\Livewire\FormComponent;
use App\Livewire\ListComponent;
use App\Livewire\PermissionAssignScreen;
use App\Livewire\LoginScreen;
use App\Livewire\RecipeForm;
use App\Livewire\Roles;
use App\Livewire\UserPermissionAssignScreen;
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

Route::get('/login', LoginScreen::class)->name("login");

//? Rotas Para Usuários Credenciados
Route::middleware('auth')->group(function () {
    Route::get('/admin/', Dashboard::class)->name("dashboard");
    Route::get('/admin/ProfileScreen', ProfileScreen::class)->name("profile");

    Route::get('/admin/{local}/List', ListComponent::class)->name("list.component");
    Route::get('/admin/{local}/Form/{id?}', FormComponent::class)->name("form.component");
    Route::get('/admin/{local}/UserForm/{id?}', UserForm::class)->name("user-form");
    Route::get('/admin/{local}/ListRoles', Roles::class)->name("roles");

    Route::get('/admin/{local}/RecipeForm/{id?}', RecipeForm::class)->name('recipe-form');

    Route::get('/admin/PermissionAssign/{id}', PermissionAssignScreen::class)->name("permission-assign");
    Route::get('/admin/UserPermissionAssign/{id}', UserPermissionAssignScreen::class)->name("user-permission-assign");
});
