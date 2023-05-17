<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
           
            'email' => ['required', 'email'],
            'password' => ['required'],
        
        ]);
 
        $user = User::where('email', $request->email)->first();

        if ( ! $user || ! Hash::check ($request->password, $user->password)) {
            
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
 
        
        $user->assignRole($request->role_id);

        return response()->json([
            'access_token' => $user->createToken('client')->plainTextToken,
        ]);
    }
}
