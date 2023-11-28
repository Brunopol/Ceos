<?php

namespace App\Http\Controllers;

use App\Models\Solicitacoe;
use App\Models\User;
use DateTime;
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
     
        
        if ($request->password != null || $request->password != '') {
       
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'required|string|max:255',
                'ramal' => 'required|string|max:255',
                'password' => 'string|max:255'
            ]);
        } else {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'required|string|max:255',
                'ramal' => 'required|string|max:255',
            ]);
    
        }
            
     

        
        $user->update($data);

        $user->removAllPermissions();

        $permissions = $request->input('permissions', []);

        foreach( $permissions as $permission)
        {
            $user->givePermissionTo($permission);
        }

        return response()->json(['message' => 'User updated successfully']);
    }


    public function indexForSolicitacoes(Request $request)
    {
        if ($request->ajax()) {
            $solicitacoes = Solicitacoe::all();



            $data = [];
            foreach ($solicitacoes as $solicitacao) {

                $userName = User::find($solicitacao->user_id);

                $row = [
                    'id' => $solicitacao->id,
                    'created_at' => $solicitacao->created_at->toISOString(),
                    'nomeUsuario' => $userName->name,
                    'motivo' => $solicitacao->acesso_motivo,
                    'actions' => [
                    ],
                ];

                $data[] = $row;
            }

            return datatables()->of($data)->toJson();
        }
    }


}
