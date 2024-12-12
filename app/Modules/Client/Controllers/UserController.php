<?php

namespace App\Modules\Client\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Client\Models\User;
use App\Modules\Client\Models\Client;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Modules\Client\jobs\SendClientDetailEmail;

class UserController extends Controller
{
    public function getUsers(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && $request->search['value']) {
            $search = $request->search['value'];
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('created_at', 'like', "%{$search}%");
        }

        if ($request->has('order')) {
            $columns = ['id', 'name','email','mobile','created_at'];
            $order = $request->order[0];
            $query->orderBy($columns[$order['column']], $order['dir']);
        }

        // Pagination
        $start = $request->start ?? 0;
        $length = $request->length ?? 10;
        $total = $query->count();

        $data = $query->skip($start)->take($length)->get();

        $data->transform(function ($item) {

            $item->action = '
                <a href="#" class="edit-user" data-bs-toggle="offcanvas" data-bs-target="#editUserModel" aria-controls="editUserModel" data-id="' . $item->id . '" title="Edit">
                    <i class="mdi mdi-lead-pencil text-primary fs-5"></i>
                </a>
                 <a href="#" class="delete-user text-danger ms-2" data-id="' . $item->id . '" title="Delete">
                    <i class="mdi mdi-delete fs-5"></i>
                </a>
                <a href="#" class="user-change-password" data-bs-toggle="offcanvas"  data-bs-target="#userChangePasswordModal" aria-controls="userChangePasswordModal" data-id="' . $item->id . '" title="cange password">
                    <i class="mdi mdi-sync fs-5 text-primary ms-1"></i>
                </a>';
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
        return view('Client::user.list');
    }

    public function store(Request $request){

        $client = Client::find(auth()->user()->client_id);

        $request->validate([

            'name' => 'required',
            'role' => 'required|exists:roles,name',
            'email' => 'required|unique:users:email',
            'mobile' => 'required|regex:/^[0-9]{10}$/',
        ]);

        $plainPassword = str()->random(8);
        $hashedPassword = Hash::make($plainPassword);

        $primary = 0;

        if($client->is_superadmin === 1){
            $primary = 1;
        }

        $user =  User::create([
            'email' => $request->email,
            'mobile' => $request->mobile,
            'name' => $request->name,
            'client_id' => $client->id,
            'password' => $hashedPassword,
            'is_primary' => $primary,
        ]);
        $user->assignRole($request->role);

        $login_url = url('/');

        dispatch(new \App\Modules\Client\Jobs\SendClientDetailEmail($user,$plainPassword,$login_url));

        return response()->json(['success' => 'User created successfully.']);
    }

    public function edit($user_id)
    {
        $user = User::find($user_id);

        return response()->json(['user' => $user]);
    }

    public function changePassword(Request $request, $user_id)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::find($user_id);
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['success' => 'Password changed successfully']);
    }


    public function update(Request $request, $user_id){

        $client = Client::find(auth()->user()->client_id);

        $request->validate([

            'name' => 'required',
            'role' => 'required|exists:roles,name',
            'email' => 'required|unique:users,email,'.$user_id,
            'mobile' => 'required|regex:/^[0-9]{10}$/',
        ]);

        $primary = 0;

        if($client->is_superadmin === 1){
            $primary = 1;
        }

        $user = User::find($user_id);

        $user->update([
            'email' => $request->email,
            'mobile' => $request->mobile,
            'name' => $request->name,
            'client_id' => $client->id,
            'is_primary' => $primary,
        ]);

        $user->assignRole($request->role);

        return response()->json(['success' => 'User updated successfully.']);
    }
}


