<?php

namespace App\Test\Controller;

use App\Entity\Groupe;
use App\Repository\GroupeRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GroupeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private GroupeRepository $repository;
    private string $path = '/groupe/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Groupe::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Groupe index');

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
            'groupe[nom]' => 'Testing',
            'groupe[identiteResponsable]' => 'Testing',
            'groupe[adressePostale]' => 'Testing',
            'groupe[nombrePersonnes]' => 'Testing',
            'groupe[nomPays]' => 'Testing',
            'groupe[hebergement]' => 'Testing',
        ]);

        self::assertResponseRedirects('/groupe/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Groupe();
        $fixture->setNom('My Title');
        $fixture->setIdentiteResponsable('My Title');
        $fixture->setAdressePostale('My Title');
        $fixture->setNombrePersonnes('My Title');
        $fixture->setNomPays('My Title');
        $fixture->setHebergement('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Groupe');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Groupe();
        $fixture->setNom('My Title');
        $fixture->setIdentiteResponsable('My Title');
        $fixture->setAdressePostale('My Title');
        $fixture->setNombrePersonnes('My Title');
        $fixture->setNomPays('My Title');
        $fixture->setHebergement('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'groupe[nom]' => 'Something New',
            'groupe[identiteResponsable]' => 'Something New',
            'groupe[adressePostale]' => 'Something New',
            'groupe[nombrePersonnes]' => 'Something New',
            'groupe[nomPays]' => 'Something New',
            'groupe[hebergement]' => 'Something New',
        ]);

        self::assertResponseRedirects('/groupe/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getIdentiteResponsable());
        self::assertSame('Something New', $fixture[0]->getAdressePostale());
        self::assertSame('Something New', $fixture[0]->getNombrePersonnes());
        self::assertSame('Something New', $fixture[0]->getNomPays());
        self::assertSame('Something New', $fixture[0]->getHebergement());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Groupe();
        $fixture->setNom('My Title');
        $fixture->setIdentiteResponsable('My Title');
        $fixture->setAdressePostale('My Title');
        $fixture->setNombrePersonnes('My Title');
        $fixture->setNomPays('My Title');
        $fixture->setHebergement('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/groupe/');
    }
}
