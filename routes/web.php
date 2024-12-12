<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Client\Controllers\AuthController;
use App\Modules\Client\Controllers\DashboardController;
use App\Modules\Client\Controllers\ModuleController;
use App\Modules\Client\Controllers\RoleController;
use App\Modules\Client\Controllers\ClientController;
use App\Modules\Client\Controllers\UserController;
use App\Modules\Client\Controllers\PrivilegeController;

Route::get('/', function () {return view('Client::client.auth.login');})->name('login');

Route::post('login', [AuthController::class, 'login'])->name('login.post');

Route::middleware('auth:web')->group(function () {

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('password-update', [AuthController::class, 'updatePassword'])->name('update-pw');
    
    //modules
    Route::get('modules-list', [ModuleController::class, 'getModules'])->name('modules.list');

    Route::post('module-store', [ModuleController::class, 'storeModule'])->name('module.post');

    Route::get('modules-edit/{module_id}', [ModuleController::class, 'editModule'])->name('module.edit');

    Route::post('module-update/{module_id}', [ModuleController::class, 'updateModule'])->name('module.update');
    
    Route::get('modules', [ModuleController::class, 'index'])->name('modules.index'); 

    Route::get('module-delete/{module_id}', [ModuleController::class, 'delete'])->name('modules.delete'); 

    Route::post('modules-update-order', [ModuleController::class, 'updateOrder'])->name('modules.update-order');


    //roles
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    
    Route::get('roles-list', [RoleController::class, 'getRoles'])->name('roles.list'); 

    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');

    Route::get('roles-edit/{role_id}', [RoleController::class, 'edit'])->name('roles.edit');

    Route::post('roles/{role_id}', [RoleController::class, 'update'])->name('roles.update');

    Route::get('roles-delete/{role_id}', [RoleController::class, 'delete'])->name('roles.delete'); 

    //clients
    Route::get('clients', [ClientController::class, 'index'])->name('clients.index');

    Route::get('clients-list', [ClientController::class, 'getClients'])->name('clients.list'); 

    Route::post('clients', [ClientController::class, 'store'])->name('client.store');

    Route::get('clients-edit/{client_id}', [ClientController::class, 'edit'])->name('clients.edit');

    Route::post('clients/{client_id}', [ClientController::class, 'update'])->name('clients.update');

    Route::get('client-delete/{client_id}', [ClientController::class, 'delete'])->name('clients.delete'); 

    //privilege

    Route::get('privileges', [PrivilegeController::class, 'index'])->name('privileges.index');

    Route::post('privileges-update', [PrivilegeController::class, 'update'])->name('privileges.update');


    //users
    Route::get('users', [UserController::class, 'index'])->name('users.index');

    Route::get('users-list', [UserController::class, 'getusers'])->name('users.list'); 

    Route::post('users', [UserController::class, 'store'])->name('user.store');

    Route::get('users-edit/{user_id}', [UserController::class, 'edit'])->name('users.edit');

    Route::post('users/{user_id}', [UserController::class, 'update'])->name('users.update');

    Route::get('user-delete/{user_id}', [UserController::class, 'delete'])->name('users.delete');

    Route::post('user-change-pw/{user_id}', [UserController::class, 'changePassword'])->name('user.change-pw');

    


    

});