<?php

namespace App\Test\Controller;

use App\Entity\Offre;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OffreControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private OffreRepository $repository;
    private string $path = '/offre/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Offre::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Offre index');

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
            'offre[nombreChambres]' => 'Testing',
            'offre[etablissement]' => 'Testing',
            'offre[typeChambre]' => 'Testing',
        ]);

        self::assertResponseRedirects('/offre/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Offre();
        $fixture->setNombreChambres('My Title');
        $fixture->setEtablissement('My Title');
        $fixture->setTypeChambre('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Offre');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Offre();
        $fixture->setNombreChambres('My Title');
        $fixture->setEtablissement('My Title');
        $fixture->setTypeChambre('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'offre[nombreChambres]' => 'Something New',
            'offre[etablissement]' => 'Something New',
            'offre[typeChambre]' => 'Something New',
        ]);

        self::assertResponseRedirects('/offre/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNombreChambres());
        self::assertSame('Something New', $fixture[0]->getEtablissement());
        self::assertSame('Something New', $fixture[0]->getTypeChambre());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Offre();
        $fixture->setNombreChambres('My Title');
        $fixture->setEtablissement('My Title');
        $fixture->setTypeChambre('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/offre/');
    }
}
