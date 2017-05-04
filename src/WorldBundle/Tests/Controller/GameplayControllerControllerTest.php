<?php

namespace WorldBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameplayControllerControllerTest extends WebTestCase
{
    public function testJoinworldgame()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/joinWorldGame');
    }

}
