<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Services\DataService;

class serviceTest extends \Tests\TestCase
{
    /** @test */
    public function serviceGetDataTest()
    {
        $service = new DataService;

        $this->assertIsArray($service->getData('convenios'));
        $this->assertIsArray($service->getData('instituicoes'));
        $this->assertIsArray($service->getData('taxas_instituicoes'));
        $this->assertIsString($service->getData('invalido'));
        $this->assertEquals("Dados não encontrados!", $service->getData('invalido'));
    }

    /** @test */
    public function serviceFilterTest()
    {
        $service = new DataService;

        $this->assertIsArray($service->filter(["PAN", "OLE"], [], null));
        $this->assertIsArray($service->filter([], ["INSS", "FEDERAL"], 60));
        $this->assertIsArray($service->filter(["PAN", "OLE"], ["INSS", "FEDERAL"], null));
        $this->assertIsArray($service->filter(["PAN", "OLE"], ["INSS", "FEDERAL"], 72));
    }
}
