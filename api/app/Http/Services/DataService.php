<?php

namespace App\Http\Services;

class DataService {
    public function getData(string $base)
    {
        $json_data;

        try{
            $json_data = json_decode(file_get_contents(app_path()."\Http\Services\data\/$base.json"));
        } catch(\Exception $error) {
            return "Dados não encontrados!";
        }

        return $json_data;
    }

    public function filter(array $instituicoes, array $convenios, $parcela)
    {
        $taxas_instituicoes = $this->getData('taxas_instituicoes');
        $instituicoes = array_map('strtoupper', $instituicoes);
        $convenios = array_map('strtoupper', $convenios);

        if($instituicoes !== null || $parcela !== null || $convenios !== null) {
            foreach($taxas_instituicoes as $key => $value) {
                if($parcela !== null && $value->parcelas !== $parcela) {
                    unset($taxas_instituicoes[$key]);
                } elseif(count($instituicoes) > 0 && !in_array($value->instituicao, $instituicoes)) {
                    unset($taxas_instituicoes[$key]);
                } elseif(count($convenios) > 0 && !in_array($value->convenio, $convenios)) {
                    unset($taxas_instituicoes[$key]);
                }
            }
        }

        return $taxas_instituicoes;
    }
}
