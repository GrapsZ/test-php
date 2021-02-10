<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    /**
     * Retourne actuellement une erreur suite à une dépendance de monolog
     * Issue : https://github.com/symfony/monolog-bundle/issues/369
     * Pull request en attente de validation : https://github.com/symfony/monolog-bundle/pull/336
     */
    public function testHomeTravels()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}