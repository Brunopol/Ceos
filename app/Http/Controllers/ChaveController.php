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
                    'horaEntrada' => $chave->horaEntrada,
                    'horaSaida' => [
                        'saida' => $chave->horaSaida,
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
}
