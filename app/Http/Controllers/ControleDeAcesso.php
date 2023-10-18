<?php

namespace App\Http\Controllers;

use App\Models\Controle_de_acesso;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ControleDeAcesso extends Controller
{


    public function index(Request $request)
    {

        if ($request->ajax()) {
            $acessos = Controle_de_acesso::all();



            $data = [];
            foreach ($acessos as $acesso) {
                $row = [
                    'nome' => $acesso->nome,
                    'rgCpf' => $acesso->rgCpf,
                    'horaEntrada' => $acesso->horaEntrada,
                    'horaSaida' => $acesso->horaSaida,
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
            'setorResponsavelPessoa' => 'nullable'
        ]);

        $acesso = Controle_de_acesso::create([
            'nome' => $validatedData['nome'],
            'rgCpf' => $validatedData['rgCpf'],
            'transportadora' => $validatedData['transportadora'],
            'placa' => $validatedData['placa'],
            'horaEntrada' => $validatedData['horaEntrada'],
            'horaSaida' => $validatedData['horaSaida'],
            'setorResponsavelPessoa' => $validatedData['setorResponsavelPessoa'],
        ]);
        

        return response()->json([
            'message' => "Encaixe '$acesso->nome' foi adicionando com sucesso",
            'id' => $acesso->id,
            'created_at' => $acesso ->created_at
        ]);
    }


}