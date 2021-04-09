<?php

namespace App\Tests\Front;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontControllerVideoTest extends WebTestCase
{
    public function testNoResults(): void
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('Search video')->form([
          'query'=> 'aaa'
        ]);
        $client->submit($form);
        $this->assertSelectorTextContains('h1', 'No results were found');
    }

    public function testResultsFound(){
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('Search video')->form([
            'query'=> 'Movies'
        ]);
        $crawler = $client->submit($form);
        $this->assertGreaterThan(4, $crawler->filter('h3')->count());
    }

}
