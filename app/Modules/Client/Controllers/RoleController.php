<?php

namespace App\Modules\Client\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Client\Models\User;
use Log;

class RoleController extends Controller
{
    public function getRoles(Request $request)
    {
        $query = Role::query();
    
        if ($request->has('search') && $request->search['value']) {
            $search = $request->search['value'];
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('created_at', 'like', "%{$search}%");
        }
   
        if ($request->has('order')) {
            $columns = ['id', 'name', 'created_at'];
            $order = $request->order[0];
            $query->orderBy($columns[$order['column']], $order['dir']);
        }
    
        // Pagination
        $start = $request->start ?? 0;
        $length = $request->length ?? 10;
        $total = $query->count();
    
        $data = $query->skip($start)->take($length)->get();
    
        // Add action buttons inline
        $data->transform(function ($item) {
            $isPrimary = auth()->user()->is_primary === 1;
            $hasDeletePermission = auth()->user()->roles()->where('role_id', 1)->exists();
            $item->action = '
                <a href="#" class="edit-role text-primary fs-5" data-bs-toggle="offcanvas" data-bs-target="#editRoleModel" aria-controls="roleModel" data-id="' . $item->id . '" title="Edit">
                    <i class="mdi mdi-lead-pencil text-primary fs-5"></i>
                </a>';

            if ($isPrimary && $hasDeletePermission) {
                $item->action .= '
                    <a href="#" class="delete-role text-danger ms-2" data-id="' . $item->id . '" title="Delete">
                        <i class="mdi mdi-delete fs-5"></i>
                    </a>';
            }
            return $item;
        });

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data,
        ]);
    }
    
    
    public function index()
    {
        return view('Client::roles.list');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->name]);

        return response()->json(['success' => 'Role created successfully.']);
    }

    public function edit(Request $request, $role_id)
    {
        $role = Role::find($role_id);

        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        return response()->json(['role' => $role]);
    }

    public function update(Request $request, $role_id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role_id,
        ]);

        $role = Role::find($role_id);

        if (!$role) {
            return response()->json(['error' => 'Role not found.'], 404);
        }
    

        $role->update([
            'name' => $request->name,
        ]);
       
        return response()->json(['success' => 'Role updated successfully.']);
    }

    public function delete($role_id){

        $role = Role::find($role_id);

        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        $role->delete();

        return response()->json(['success' => 'Role deleted successfully']);
    }


}
