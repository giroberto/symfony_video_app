<?php

namespace App\Tests\Front;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontControllerSecurityTest extends WebTestCase
{
    /**
     * @dataProvider getSecureUrls
     */
    public function testSecureUrls(string $urls): void
    {
        $client = static::createClient();
        $client->request('GET', $urls);
        $client->followRedirects();
        $this->assertStringContainsString('login', $client->getResponse()->headers->get('location'));
    }

    public function getSecureUrls(): \Generator
    {
        yield ['/admin/videos'];
        yield ['/admin'];
        yield ['/admin/su/categories'];
        yield ['/admin/su/delete-category/1'];
    }
}
