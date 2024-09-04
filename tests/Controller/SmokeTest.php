<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
{
  $client = self::createClient();
        $client->followRedirects(false);
        $client->request('GET', '/api/account/me');
        self::assertResponseStatusCodeSame(401);
}
