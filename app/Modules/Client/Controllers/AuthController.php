<?php

namespace App\Modules\Client\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Modules\Client\Models\Client;
use App\Modules\Client\Models\User;
use Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // $user = User::where('email', $request->email)->whereNotNull('deleted_at')->first();

        // if (!$user) {
        //     return response()->json(['errors' => ['subscribe' => 'Your account is not active, please contact admin.']], 422);
        // }

        if (!Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            
            return response()->json(['errors' => ['email' => 'Invalid email or password']], 422);
        }

        $user = Auth::guard('web')->user();

        if ($user->client_id) {
            $isSubscribed = Client::active()->where('id', $user->client_id)->where('is_subscribed',1)->first();
    
            if (!$isSubscribed) {
                Auth::guard('web')->logout(); 
                return response()->json(['errors' => ['subscribe' => 'You are not subscribed. Please subscribe to continue.']], 422);
            }
        }
        return response()->json(['redirect' => route('dashboard')]);
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Invalid current password'], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();
    
        return response()->json(['success' => 'Password updated successfully']);
    }
    
}
