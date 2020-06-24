<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Services\DataService;
use App\Http\Controllers\Controller;

class SimulatorController extends Controller
{
    private $dataService;

    function __construct() {
        $this->dataService = new DataService;
    }

    public function listInstitutions()
    {
        $data = $this->dataService->getData('instituicoes');

        return response()->json($data);
    }

    public function listAgreements()
    {
        $data = $this->dataService->getData('convenios');

        return response()->json($data);
    }

    public function simulate(Request $request)
    {
        $request->validate([
            'valor_emprestimo' => 'required|numeric'
        ]);

        $valor_emprestimo = $request->valor_emprestimo;
        $instituicoes = $request->instituicoes ?? [];
        $convenios = $request->convenios ?? [];
        $parcela = $request->parcela ?? null;

        $taxas_instituicoes = $this->dataService->filter($instituicoes, $convenios, $parcela);

        if(count($taxas_instituicoes) === 0) {
            return response()->json("Nenhum crédito disponivel");
        }

        $propostas = $this->calculate($taxas_instituicoes, $valor_emprestimo);

        return response()->json($propostas);
    }

    private function calculate(array $taxas_instituicoes, float $valor_emprestimo)
    {
        $propostas = [];
        foreach($taxas_instituicoes as $taxa) {

            $valor = $taxa->coeficiente * $valor_emprestimo;

            $data = [
                "taxa" => $taxa->taxaJuros,
                "parcela" => $taxa->parcelas,
                "valor_parcela" => (float) number_format($valor, 2),
                "convenio" => $taxa->convenio
            ];

            array_push($propostas, $data);
        }

        return $propostas;
    }
}
