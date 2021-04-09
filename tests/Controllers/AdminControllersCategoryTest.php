<?php

namespace App\Tests\Controllers;

use App\Entity\Category;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Tests\Rollback;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllersCategoryTest extends WebTestCase
{
    use Rollback;
    private KernelBrowser $client;
    private $entityManager;

    public function testTextOnPage(): void
    {
        $crawler = $this->client->request('GET', '/admin/su/categories');
        $this->assertSame('Categories list', $crawler->filter('h2')->text());
        $this->assertStringContainsString('Electronics', $this->client->getResponse()->getContent());
    }

    public function testNumberOfItems()
    {
        $crawler = $this->client->request('GET', '/admin/su/categories');
        $this->assertCount(12, $crawler->filter('option'));
    }

    public function testCreateCategory()
    {
        $crawler = $this->client->request('GET', '/admin/su/categories');
        $form = $crawler->selectButton('Add')->form([
            'category[parent]'=>1,
            'category[name]' => 'Other Eletronics'
        ]);
        $this->client->submit($form);
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name'=>'Other Eletronics']);

        $this->assertSame($category->getName(), 'Other Eletronics');
    }

    public function testEditCategory()
    {
        $crawler = $this->client->request('GET', '/admin/su/edit-category/1');
        $form = $crawler->selectButton('Save')->form([
            'category[parent]'=>0,
            'category[name]' => 'Eletronics 2'
        ]);
        $this->client->submit($form);
        $category = $this->entityManager->getRepository(Category::class)->find(1);

        $this->assertSame($category->getName(), 'Eletronics 2');
    }

    public function testDeleteCategory()
    {
        $this->client->request('GET', '/admin/su/delete-category/1');
        $category = $this->entityManager->getRepository(Category::class)->find(1);

        $this->assertNull($category);
    }
}
