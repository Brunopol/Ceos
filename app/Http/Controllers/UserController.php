<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    
    public function index(Request $request): View
    {
        $users = User::all();
        return view('users', [
            "users" => $users,
        ]);
    }

    public function show($id) 
    {
        $user = User::with('permissions')->find($id);
    
        return response()->json($user);
    }
    

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            // Add validation rules for other fields here
        ]);

        $user->update($data);

        $user->removAllPermissions();

        $permissions = $request->input('permissions', []);

        foreach( $permissions as $permission)
        {
            $user->givePermissionTo($permission);
        }

        return response()->json(['message' => 'User updated successfully']);
    }
}
