<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as WebTestCaseBase;

class WebTestCase extends WebTestCaseBase
{
    protected KernelBrowser $client;
    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->client->disableReboot();
        $this->client->catchExceptions(true);

        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->createSchema($metadata);
    }

    public function loadFixtures(array $fixtures): void
    {
        $loader = new Loader();

        foreach ($fixtures as $fixtureClass) {
            $fixture = new $fixtureClass();
            $loader->addFixture($fixture);
        }

        $purger = new ORMPurger($this->entityManager);
        $executor = new ORMExecutor($this->entityManager, $purger);

        $executor->execute($loader->getFixtures());
    }

    public function getJsonResponseAsArray(): array
    {
        return \json_decode($this->client->getResponse()->getContent(), true);

    }
}
