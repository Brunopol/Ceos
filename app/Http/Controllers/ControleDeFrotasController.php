<?php

namespace App\Http\Controllers;

use App\Models\Controle_de_acesso;
use App\Models\Encaixe;
use App\Models\Solicitacoe;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ControleDeFrotasController extends Controller
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

        return view('controleDeFrotas');
    }
}