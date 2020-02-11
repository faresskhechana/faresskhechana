<?php

namespace ClubBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClubControllerTest extends WebTestCase
{
    public function testAjouter()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Ajouter');
    }

    public function testModifier()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Modifier');
    }

    public function testAfficher()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Afficher');
    }

}
