<?php

namespace App\Http\Controllers;

use App\Models\Controle_de_acesso;
use App\Models\Encaixe;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class ControleDeAcessoController extends Controller
{


    public function index(Request $request)
    {

        if ($request->ajax()) {
            $acessos = Controle_de_acesso::all();



            $data = [];
            foreach ($acessos as $acesso) {
                $row = [
                    'created_at' => $acesso->created_at->toISOString(),
                    'nome' => $acesso->nome,
                    'rgCpf' => $acesso->rgCpf,
                    'empresa' => $acesso->transportadora,
                    'placa' => $acesso->placa,
                    'pessoaResponsavel' => $acesso->pessoaResponsavel,
                    'setorResponsavel' => $acesso->setorResponsavel,
                    'horaEntrada' => $acesso->horaEntrada,
                    'horaSaida' => [
                        'saida' => $acesso->horaSaida,
                        'id' => $acesso->id
                    ],
                    'actions' => [
                        'url_show' => route('controleDeAcessos.show', $acesso->id),
                        'url_delete' => route('controleDeAcessos.delete', $acesso->id)
                    ]
                ];

                $data[] = $row;
            }

            return datatables()->of($data)->toJson();
        }

        return view('ControleDeAcesso');
    }

    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required',
            'rgCpf' => 'required',
            'transportadora' => 'nullable',
            'placa' => 'nullable',
            'horaEntrada' => 'nullable',
            'horaSaida' => 'nullable',
            'pessoaResponsavel' => 'nullable',
            'setorResponsavel' => 'nullable'
        ]);

        $acesso = Controle_de_acesso::create([
            'nome' => strtoupper($validatedData['nome']),
            'rgCpf' => strtoupper($validatedData['rgCpf']),
            'transportadora' => strtoupper($validatedData['transportadora']),
            'placa' => strtoupper($validatedData['placa']),
            'horaEntrada' => $validatedData['horaEntrada'],
            'horaSaida' => $validatedData['horaSaida'],
            'pessoaResponsavel' => strtoupper($validatedData['pessoaResponsavel']),
            'setorResponsavel' => strtoupper($validatedData['setorResponsavel'])
        ]);
        

        return response()->json([
            'message' => "Encaixe '$acesso->nome' foi adicionando com sucesso",
            'id' => $acesso->id,
            'created_at' => $acesso->created_at
        ]);
    }

    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'nome' => 'required',
            'rgCpf' => 'required',
            'transportadora' => 'nullable',
            'placa' => 'nullable',
            'horaEntrada' => 'nullable',
            'horaSaida' => 'nullable',
            'pessoaResponsavel' => 'nullable',
            'setorResponsavel' => 'nullable',
        ]);

        $acesso = Controle_de_acesso::find($id);

        $acesso->update([
            'nome' => strtoupper($validatedData['nome']),
            'rgCpf' => $validatedData['rgCpf'],
            'transportadora' => strtoupper($validatedData['transportadora']),
            'placa' => strtoupper($validatedData['placa']),
            'horaEntrada' => $validatedData['horaEntrada'],
            'horaSaida' => $validatedData['horaSaida'],
            'pessoaResponsavel' => strtoupper($validatedData['pessoaResponsavel']),
            'setorResponsavel' => strtoupper($validatedData['setorResponsavel']),
        ]);

        return response()->json([
            'message' => "Acesso '$acesso->nome' atualizado com sucesso"
        ]);
    }

    public function updateReg(Request $request, $id)
    {

        $validatedData = $request->validate([
            'horaSaida' => 'nullable'
        ]);

        $acesso = Controle_de_acesso::find($id);

        $acesso->update([
            'horaSaida' => $validatedData['horaSaida']
        ]);

        return response()->json([
            'message' => "Acesso '$acesso->nome' atualizado com sucesso"
        ]);
    }

    public function delete($id)
    {
        $acesso = Controle_de_acesso::find($id);
        $acesso->delete();

        return response()->json([
            'message' => "Acesso '$acesso->nome' deletado com sucesso"
        ]);
    }

    public function show($id)
    {

        $acesso = Controle_de_acesso::find($id);

        return response()->json($acesso);
    }
}
