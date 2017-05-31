<?php

namespace WorldBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BottleControllerControllerTest extends WebTestCase
{
    public function testUpdatemessage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/updateMessage');
    }

}
