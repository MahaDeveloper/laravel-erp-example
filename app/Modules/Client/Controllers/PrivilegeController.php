<?php

namespace App\Modules\Client\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Client\Models\Module;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PrivilegeController extends Controller
{

    public function index(Request $request)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $modules = Module::all();

        return view('Client::privilege.list', compact('roles', 'permissions','modules'));
    }

}