<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class routesTest extends TestCase
{
    /**
     * A basic feature test for instituitions route.
     *
     * @return void
     */
    public function testInstituicoes()
    {
        $data_response = [
            "chave" => "PAN",
            "valor" => "Pan"
        ];

        $response = $this->get('/api/instituicoes');

        $response->assertJsonFragment($data_response);
        $response->assertStatus(200);
    }

    public function testConvenios()
    {
        $data_response = [
            "chave" => "INSS",
            "valor" => "INSS"
        ];

        $response = $this->get('/api/convenios');

        $response->assertJsonFragment($data_response);
        $response->assertStatus(200);
    }

    public function testSimulator()
    {
        $data = [
            "valor_emprestimo" => 11750
        ];

        $data_response = [
            "taxa" => 2.05,
            "parcela" => 72,
            "valor_parcela" => 305.97,
            "convenio"=> "INSS"
        ];

        $response = $this->postJson('/api/simular', $data);
        $response->assertJsonFragment($data_response);

        $response->assertStatus(200);
    }
}
