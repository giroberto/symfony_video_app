<?php

namespace App\Tests\Controllers;

use App\Entity\Category;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllersCategoryTest extends WebTestCase
{
    private KernelBrowser $client;
    private $entityManager;

    protected function setUp(): void{
        parent::setup();
//        self::bootKernel();

        $this->client = self::createClient();
        $container = self::$container;
        $repository = $container->get(UserRepository::class);
        $testUser = $repository->find(1);
        $this->client->loginUser($testUser);
        $this->client->disableReboot();
        $this->entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->entityManager->beginTransaction();
        $this->entityManager->getConnection()->setAutoCommit(false);


    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->rollback();
        $this->entityManager->close();
        $this->entityManager = null;

    }

    public function testTextOnPage(): void
    {
        $crawler = $this->client->request('GET', '/admin/su/categories');
        $this->assertSame('Categories list', $crawler->filter('h2')->text());
        $this->assertStringContainsString('Electronics', $this->client->getResponse()->getContent());
    }

    public function testNumberOfItems()
    {
        $crawler = $this->client->request('GET', '/admin/su/categories');
        $this->assertCount(10, $crawler->filter('option'));
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
