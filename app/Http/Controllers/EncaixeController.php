<?php

namespace App\Http\Controllers;

use App\Models\Encaixe;
use App\Models\Encaixe_movimento;
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

    public function addMovimento(Request $request)
    {

        $validatedData = $request->validate([
            'encaixeID' => 'required',
            'nome' => 'required',
            'largura' => 'required',
            'tecido' => 'required',
            'quantidade' => 'required',
            'parImper' => 'required',
            'consumo_nome' => 'array',
            'consumo_valor' => 'array',
        ]);

        $encaixe = Encaixe::find($validatedData['encaixeID']);

        $encaixeMovimento = $encaixe->movimentos()->create([
            'nome' => $validatedData['nome'],
            'largura' => $validatedData['largura'],
            'tecido' => $validatedData['tecido'],
            'quantidade' => $validatedData['quantidade'],
            'parImper' => $validatedData['parImper'],
            'notas' => 'TODO',
        ]);

        if (isset($validatedData['consumo_nome']) && is_array($validatedData['consumo_nome'])) {
            $consumos = [];
            foreach ($validatedData['consumo_nome'] as $index => $consumoNome) {
                $consumos[] = [
                    'nome' => $consumoNome,
                    'valor' => $validatedData['consumo_valor'][$index],
                ];
            }
    
            // Delete existing consumos and create new ones
            $encaixeMovimento->consumos()->delete(); 
            $encaixeMovimento->consumos()->createMany($consumos);
        }
        

        return response()->json('ADD com sucesso');

    }

    public function updateMovimento(Request $request, $id)
    {
        
        $validatedData = $request->validate([
            'nome' => 'required',
            'largura' => 'required',
            'tecido' => 'required',
            'quantidade' => 'required',
            'parImper' => 'required',
            'consumo_nome' => 'array',
            'consumo_valor' => 'array',
        ]);
    
        $encaixeMovimento = Encaixe_movimento::find($id);
    
        $encaixeMovimento->update([
            'nome' => $validatedData['nome'],
            'largura' => $validatedData['largura'],
            'tecido' => $validatedData['tecido'],
            'quantidade' => $validatedData['quantidade'],
            'parImper' => $validatedData['parImper'],
        ]);
    
        if (isset($validatedData['consumo_nome']) && is_array($validatedData['consumo_nome'])) {
            $consumos = [];
            foreach ($validatedData['consumo_nome'] as $index => $consumoNome) {
                $consumos[] = [
                    'nome' => $consumoNome,
                    'valor' => $validatedData['consumo_valor'][$index],
                ];
            }
    
            // Delete existing consumos and create new ones
            $encaixeMovimento->consumos()->delete(); 
            $encaixeMovimento->consumos()->createMany($consumos);
        }
    
        return response()->json(['message' => 'Encaixe movimento updated successfully']);
    }
    

}
