<?php

namespace App\Test\Controller;

use App\Entity\Attribution;
use App\Repository\AttributionRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AttributionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AttributionRepository $repository;
    private string $path = '/attribution/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Attribution::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Attribution index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'attribution[nombreChambres]' => 'Testing',
            'attribution[etablissement]' => 'Testing',
            'attribution[typeChambre]' => 'Testing',
            'attribution[groupe]' => 'Testing',
        ]);

        self::assertResponseRedirects('/attribution/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Attribution();
        $fixture->setNombreChambres('My Title');
        $fixture->setEtablissement('My Title');
        $fixture->setTypeChambre('My Title');
        $fixture->setGroupe('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Attribution');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Attribution();
        $fixture->setNombreChambres('My Title');
        $fixture->setEtablissement('My Title');
        $fixture->setTypeChambre('My Title');
        $fixture->setGroupe('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'attribution[nombreChambres]' => 'Something New',
            'attribution[etablissement]' => 'Something New',
            'attribution[typeChambre]' => 'Something New',
            'attribution[groupe]' => 'Something New',
        ]);

        self::assertResponseRedirects('/attribution/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNombreChambres());
        self::assertSame('Something New', $fixture[0]->getEtablissement());
        self::assertSame('Something New', $fixture[0]->getTypeChambre());
        self::assertSame('Something New', $fixture[0]->getGroupe());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Attribution();
        $fixture->setNombreChambres('My Title');
        $fixture->setEtablissement('My Title');
        $fixture->setTypeChambre('My Title');
        $fixture->setGroupe('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/attribution/');
    }
}
