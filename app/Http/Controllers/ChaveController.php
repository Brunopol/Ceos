<?php

namespace App\Http\Controllers;

use App\Models\Chave;
use DateTime;
use Illuminate\Http\Request;

class ChaveController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $chaves = Chave::all();

            $data = [];
            foreach ($chaves as $chave) {

                $dataSaida = null;
                if ($chave->dataSaida != null) {
                    $dateTime = new DateTime($chave->dataSaida);
                    $dataSaida = $dateTime->format('d/m/Y');
                }

                $row = [
                    'created_at' => $chave->created_at->toISOString(),
                    'nomePessoa' => $chave->nomePessoa,
                    'nomeChave' => $chave->nomeChave,
                    'horaEntrada' => $chave->novaHoraEntrada,
                    'horaSaida' => [
                        'saida' => $chave->novaHoraSaida,
                        'id' => $chave->id
                    ],
                    'actions' => [
                        'url_show' => 'default change',
                        'url_delete' => 'default change'
                    ],
                    'dataSaida' => $dataSaida
                ];

                $data[] = $row;
            }

            return datatables()->of($data)->toJson();
        }


        return view('chaves');
    }

    public function add(Request $request) 
    {

        $validatedData = $request->validate([
            'nomePessoa' => 'required',
            'nomeChave' => 'required',
            'horaEntrada' => 'required',
            'horaSaida' => 'nullable'
            
        ]);

        $chave = Chave::create([
            'nomePessoa' => strtoupper($validatedData['nomePessoa']),
            'nomeChave' => strtoupper($validatedData['nomeChave']),
            'novaHoraEntrada' => $validatedData['horaEntrada'],
            'novaHoraSaida' => $validatedData['horaSaida']
        ]);

        return response()->json([
            'message' => "Chave '$chave->nomeChave' foi registrado com sucesso",
            'id' => $chave->id,
            'created_at' => $chave->created_at
        ]);

    }

    public function regSaida(Request $request, $id) 
    {
        $validatedData = $request->validate([
            'horaSaida' => 'nullable',
            'dataSaida' => 'nullable'
        ]);

        $chave = Chave::find($id);

        $chave->update([
            'novaHoraSaida' => $validatedData['horaSaida'],
            'dataSaida' => $validatedData['dataSaida']
        ]);

        return response()->json([
            'message' => "Chave '$chave->nomeChave' atualizado com sucesso"
        ]);
    }

    public function show($id) {
        $chave = Chave::find($id);
        return response()->json($chave);
    }

    public function update(Request $request) {

        $validatedData = $request->validate([
            'nomePessoa' => 'required',
            'nomeChave' => 'required',
            'horaEntrada' => 'required',
            'horaSaida' => 'nullable'
            
        ]);

        $chave = Chave::find($request->id);

        $chave->update([
            'nomePessoa' => strtoupper($validatedData['nomePessoa']),
            'nomeChave' => strtoupper($validatedData['nomeChave']),
            'novaHoraEntrada' => $validatedData['horaEntrada'],
            'novaHoraSaida' => $validatedData['horaSaida']
        ]);

        return response()->json([
            'message' => "Chave '$chave->nomeChave' atualizado com sucesso"
        ]);

    }

    public function chaveSugestao($input) {

        $query = $input;


        try {

            $suggestions = Chave::where('nomeChave', 'like', '%' . $query . '%')->select('nomeChave')->get();
            return response()->json($suggestions);
        } catch (\Exception $e) {
            return response()->json('null');
        }

    }

}
