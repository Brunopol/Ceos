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
        $user = User::find($id);
        return response()->json($user);
    }
}
