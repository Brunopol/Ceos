<?php

namespace App\Http\Controllers;

use App\Models\Controle_de_acesso;
use App\Models\Encaixe;
use App\Models\Solicitacoe;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ControleDeAcessoController extends Controller
{


    public function index(Request $request)
    {

        if ($request->ajax()) {
            $acessos = Controle_de_acesso::where('deletado', false)->get();

            $data = [];
            foreach ($acessos as $acesso) {

                $dataSaida = null;
                if ($acesso->dataSaida != null) {
                    $dateTime = new DateTime($acesso->dataSaida);
                    $dataSaida = $dateTime->format('d/m/Y');
                }

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
                    ],
                    'dataSaida' => $dataSaida
                ];

                $data[] = $row;
            }

            return datatables()->of($data)->toJson();
        }

        return view('ControleDeAcesso');
    }

    public function add(Request $request)
    {

        $user = auth()->user();


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

        $acesso->user_id = $user->id;
        $acesso->save();

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
            'dataSaida' => 'nullable',
            'horaSaida' => 'nullable',
            'pessoaResponsavel' => 'nullable',
            'setorResponsavel' => 'nullable'
        ]);

        $acesso = Controle_de_acesso::find($id);

        $acesso->update([
            'nome' => strtoupper($validatedData['nome']),
            'rgCpf' => $validatedData['rgCpf'],
            'transportadora' => strtoupper($validatedData['transportadora']),
            'placa' => strtoupper($validatedData['placa']),
            'horaEntrada' => $validatedData['horaEntrada'],
            'dataSaida' => $validatedData['dataSaida'],
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
            'horaSaida' => 'nullable',
            'dataSaida' => 'nullable'
        ]);


        Log::debug($validatedData['dataSaida']);

        $acesso = Controle_de_acesso::find($id);

        $acesso->update([
            'horaSaida' => $validatedData['horaSaida'],
            'dataSaida' => $validatedData['dataSaida']
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

        $acesso = Controle_de_acesso::with('user')->find($id);

        return response()->json($acesso);
    }


    //search api

    public function getAcessosPeloNome($nome)
    {

        $query = $nome;

        // Replace this logic with your actual database query to get MOVIMENTO suggestions

        try {

            $suggestions = Controle_de_acesso::where('nome', 'like', '%' . $query . '%')->select('id', 'nome')->get();
            return response()->json($suggestions);
        } catch (\Exception $e) {
            return response()->json('null');
        }
    }

    public function getAcessosPelaEmpresa($empresa)
    {
        $query = $empresa;

        try {
            $suggestions = Controle_de_acesso::where('transportadora', 'like', '%' . $query . '%')->get(['transportadora']);
            return response()->json($suggestions);
        } catch (\Exception $e) {
            return response()->json(null);
        }
    }

    public function getAcessosPeloSetor($setor, $empresa)
    {


        if ($setor == '*') {
            try {
                $suggestions = Controle_de_acesso::where('transportadora', 'like', $empresa)->get(['setorResponsavel', 'transportadora']);
                return response()->json($suggestions);
            } catch (\Exception $e) {
                return response()->json(null);
            }
        }


        $setorQuery = '%' . $setor . '%';
        $empresaQuery = '%' . $empresa . '%';

        try {
            $suggestions = Controle_de_acesso::where('setorResponsavel', 'like', $setorQuery)
                ->where('transportadora', 'like', $empresaQuery)
                ->get(['setorResponsavel', 'transportadora']);

            return response()->json($suggestions);
        } catch (\Exception $e) {
            return response()->json(null);
        }
    }

    public function getAcessosPelaPessoa($pessoa, $setor)
    {
        if ($pessoa == '*') {
            try {
                $suggestions = Controle_de_acesso::where('setorResponsavel', 'like', $setor)->get(['pessoaResponsavel']);
                return response()->json($suggestions);
            } catch (\Exception $e) {
                return response()->json(null);
            }
        }


        $pessoaQuery = '%' . $pessoa . '%';
        $setorQuery = '%' . $setor . '%';

        try {
            $suggestions = Controle_de_acesso::where('pessoaResponsavel', 'like', $pessoaQuery)
                ->where('setorResponsavel', 'like', $setorQuery)
                ->get(['pessoaResponsavel']);

            return response()->json($suggestions);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

    public function solicitarDeletagem(Request $request)
    {

        $acesso = Controle_de_acesso::find($request->id);


        $acesso->update([
            'deletado' => true,
        ]);

        $user = auth()->user();

        Solicitacoe::create([
            'user_id' => $user->id,
            'acesso_id' => $request->id,
            'acesso_motivo' => $request->motivo
        ]);

        return response()->json(['message' => 'Acesso deletado com sucesso']);
    }
}
