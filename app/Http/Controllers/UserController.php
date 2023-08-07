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
        return view('users');
    }

    public function ajax(Request $request): JsonResponse
{
    $users = User::all();

    return response()->json(['users' => $users]);
}


}
