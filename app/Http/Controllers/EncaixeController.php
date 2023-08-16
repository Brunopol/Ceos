<?php

namespace App\Http\Controllers;

use App\Models\Encaixe;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EncaixeController extends Controller
{
    
    public function index(Request $request): View
    {
        $encaixes = Encaixe::all();
        return view('encaixe', [
            "encaixes" => $encaixes,
        ]);
    }

    public function show($id) 
    {
        $encaixe = Encaixe::with(['movimentos', 'movimentos.consumos'])->find($id);

        return response()->json($encaixe);
    }

}
