<?php

namespace App\Tests\Entity;

use App\Entity\Travel;
use PHPUnit\Framework\TestCase;

class TravelTest extends TestCase
{
    public function testCreateEntity()
    {
        $travel = new Travel();
        $travel->setName('Los Angeles')
            ->setIsActive(false)
            ->setPrice(2000);

        $this->assertEquals('Los Angeles', $travel->getName());
        $this->assertEquals(false, $travel->getIsActive());
        $this->assertEquals(2000, $travel->getPrice());

        $this->assertNotEmpty($travel->getName());
        $this->assertIsBool($travel->getIsActive());
        $this->assertIsFloat($travel->getPrice());
    }
}