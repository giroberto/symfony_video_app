<?php

namespace App\Tests;

use App\Repository\UserRepository;

trait Rollback
{
    public function setUp(): void
    {
        $this->client = self::createClient();
        $container = self::$container;
        $repository = $container->get(UserRepository::class);
        $testUser = $repository->find(1);
        $this->client->loginUser($testUser);
        $this->client->disableReboot();
        $this->entityManager = $this->client->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
