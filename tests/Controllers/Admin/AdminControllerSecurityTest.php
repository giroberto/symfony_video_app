<?php

namespace App\Tests\Controllers\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdminControllerSecurityTest extends WebTestCase
{
    /**
     * @dataProvider getAccessDataUrls
     */
    public function testDenyAccessUsers(string $method, string $url): void
    {
        $client = self::createClient();
        $container = self::$container;
        $repository = $container->get(UserRepository::class);
        $testUser = $repository->find(2);
        $client->loginUser($testUser);
        $client->request($method, $url);

        $this->assertSame(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    public function getAccessDataUrls(): \Generator
    {
        yield ['GET', '/admin/su/categories'];
        yield ['GET', '/admin/su/edit-category/1'];
        yield ['GET', '/admin/su/delete-category/1'];
        yield ['GET', '/admin/su/users'];
    }

    public function testAdminSu(){
        $client = self::createClient();
        $container = self::$container;
        $repository = $container->get(UserRepository::class);
        $testUser = $repository->find(1);

        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/admin/su/categories');

        $this->assertSame('Categories list', $crawler->filter('h2')->text());

    }
}
