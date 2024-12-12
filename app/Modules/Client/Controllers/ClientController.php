<?php

namespace App\Modules\Client\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Client\Models\Client;
use App\Modules\Client\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Modules\Client\jobs\SendClientDetailEmail;
use Log;

class ClientController extends Controller
{
    public function getClients(Request $request)
    {
        $query = Client::query();
    
        if ($request->has('search') && $request->search['value']) {
            $search = $request->search['value'];
            $query->where('company_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('created_at', 'like', "%{$search}%");
        }
   
        if ($request->has('order')) {
            $columns = ['id', 'company_name', 'company_logo','email','mobile','created_at'];
            $order = $request->order[0];
            $query->orderBy($columns[$order['column']], $order['dir']);
        }
    
        // Pagination
        $start = $request->start ?? 0;
        $length = $request->length ?? 10;
        $total = $query->count();
    
        $data = $query->skip($start)->take($length)->get();

        $data->transform(function ($item) {
            if($item->company_logo){
                $item->company_logo = '<img src="' . asset($item->company_logo) . '"  alt="Company Logo">';
            }else{
                $item->company_logo = '<img src="' . asset('images/clients/default-company.jpg') . '"  alt="Company Logo">';
            }
            
           
            $item->action = '              
                <a href="#" class="edit-client" data-bs-toggle="offcanvas" data-bs-target="#editClientModel" aria-controls="editClientModel" data-id="' . $item->id . '" title="Edit">
                    <i class="mdi mdi-lead-pencil text-primary fs-5"></i>
                </a>
                 <a href="#" class="delete-client text-danger ms-2" data-id="' . $item->id . '" title="Delete">
                    <i class="mdi mdi-delete fs-5"></i>
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
        return view('Client::client.list');
    }

    public function store(Request $request){

        $request->validate([
            'company_name' => 'required|unique:clients,company_name',
            'company_logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required',
            'email' => 'required|email|unique:clients,email',
            'mobile' => 'required|regex:/^[0-9]{10}$/',
            'address' => 'required',
            'pin_code' => 'required|digits:6',
            'state' => 'required',
            'country' => 'required',
        ]);

        $imageName = time() . '.' . $request->company_logo->extension();
        $imagePath = 'images/clients/';
        $fullPath  = $imagePath . $imageName;
        $request->company_logo->move(public_path($imagePath), $imageName);
       
        $client =  Client::create([
            'company_name' => $request->company_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'display_name' => $request->name,
            'primary_address' => $request->address,
            'pin_code' => $request->pin_code,
            'is_subscribed' => $request->subscribe,
            'company_logo' => $fullPath,
            'state' => $request->state,
            'country' => $request->country,
        ]);

        $plainPassword = str()->random(8);  
        $hashedPassword = Hash::make($plainPassword);

        $user = User::create([
            'name' =>$request->name,
            'client_id' =>$client->id,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => $hashedPassword,
            'is_primary' => 1,
        ]);

        $login_url = url('/');

        dispatch(new \App\Modules\Client\Jobs\SendClientDetailEmail($client,$plainPassword,$login_url));

        return response()->json(['success' => 'Client created successfully.']);
    }

    public function delete($client_id){

        $client = Client::find($client_id);

        if (!$client) {
            return response()->json(['error' => 'Client not found'], 404);
        }
        User::where('client_id',$client_id)->delete();

        $client->delete();

        return response()->json(['success' => 'Client deleted successfully']);
    }

    public function update(Request $request, $client_id){
               
        $request->validate([
            'company_name' => 'required|unique:clients,company_name,'.$client_id,
            'company_logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required',
            'email' => 'required|email|unique:clients,email,'.$client_id,
            'mobile' => 'required|regex:/^[0-9]{10}$/',
            'address' => 'required',
            'pin_code' => 'required|digits:6',
            'state' => 'required',
            'country' => 'required',
        ]);

        $imageName = time() . '.' . $request->company_logo->extension();
        $imagePath = 'images/clients/';
        $fullPath  = $imagePath . $imageName;
        $request->company_logo->move(public_path($imagePath), $imageName);

        $client = Client::find($client_id);
       
        $client->update([
            'company_name' => $request->company_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'display_name' => $request->name,
            'primary_address' => $request->address,
            'pin_code' => $request->pin_code,
            'is_subscribed' => $request->subscribe,
            'company_logo' => $fullPath,
            'state' => $request->state,
            'country' => $request->country,
        ]);

        $users = User::where('client_id',$client_id)->get();

        foreach($users as $user){

            $user = $user->update([
                'name' =>$request->name,
                'client_id' =>$client->id,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'is_primary' => 1,
            ]);
        }
        

        return response()->json(['success' => 'Client created successfully.']);

    }

    public function edit($client_id)
    {
        $client = Client::find($client_id);

        return response()->json(['client' => $client]);
    }



}
