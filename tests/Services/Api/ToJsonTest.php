<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;


class ToJsonTest extends TestCase
{
    public function testConstructJsonResponse()
    {
        $responseType = Response::HTTP_OK;
        $array = ["success" => false, "statusCode" => $responseType];

        $this->assertArrayHasKey("success", $array);
        $this->assertArrayHasKey("statusCode", $array);
        $this->assertIsInt($responseType);

        $this->assertEquals($array["statusCode"], $responseType);
    }
}