<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CatalogueFunctionalTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/catalogue');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body > div.container.col-md-12.col-xs-12.col-sm-12.col-lg-12 > section > h2', 'Catalogue');
    }
}
