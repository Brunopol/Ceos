<?php

namespace App\Http\Controllers;

use App\Models\Encaixe;
use App\Models\Encaixe_movimento;
use App\Models\Encaixe_movimento_consumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    public function delete($id)
    {

        $encaixe = Encaixe::find($id);
        $encaixe->delete();

        return response()->json(['message' => "Encaixe '$encaixe->referencia' deletado com sucesso"]);
    }

    public function addEncaixe(Request $request)
    {
        $validatedData = $request->validate([
            'referencia' => 'required',
        ]);

        $encaixe = Encaixe::create([
            'referencia' => $validatedData['referencia'],
        ]);

        return response()->json([
            'message' => "Encaixe '$encaixe->referencia' foi adicionando com sucesso",
            'id' => $encaixe->id,
            'created_at' => $encaixe->created_at
        ]);
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
            'consumo_nome' => ['nullable', 'array'],
            'consumo_valor' => ['nullable', 'array'],
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


        return response()->json([
            'message' => "Encaixe '$encaixe->referencia' movimento '$encaixeMovimento->nome' adicionado com sucesso",
            'referencia' => $encaixeMovimento->encaixe->referencia,
            'url' => route('encaixe.show', ['id' => $encaixeMovimento->encaixe->id]),
            'created_at' => $encaixeMovimento->created_at,
        ]);
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

        return response()->json([
            'message' => "Encaixe movimento '$encaixeMovimento->nome' atualizado com sucesso",
            'referencia' => $encaixeMovimento->encaixe->referencia,
            'url' => route('encaixe.show', ['id' => $encaixeMovimento->encaixe->id]),
            'created_at' => $encaixeMovimento->created_at,
        ]);        
    }

    public function deletarMovimento($id)
    {
        $encaixeMovimento = Encaixe_movimento::find($id);
        $encaixeMovimento->delete();
        return response()->json([
            'message' => "Encaixe movimento '$encaixeMovimento->nome' deletado com sucesso",
            'referencia' => $encaixeMovimento->encaixe->referencia,
            'url' => route('encaixe.show', ['id' => $encaixeMovimento->encaixe->id]),
            'created_at' => $encaixeMovimento->created_at,
        ]);
    }

    public function deletarConsumo($id)
    {
        $consumo = Encaixe_movimento_consumo::find($id);
        $consumo->delete();
        return response()->json([
            'message' => "Consumo '$consumo->nome' deletado com sucesso",
            'referencia' => $consumo->encaixe_movimento->encaixe->referencia,
            'url' => route('encaixe.show', ['id' => $consumo->encaixe_movimento->encaixe->id]),
            'created_at' => $consumo->created_at,

        
        ]);
    }
}
