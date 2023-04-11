<?php

namespace App\Test\Controller;

use App\Entity\Etablissement;
use App\Repository\EtablissementRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EtablissementControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EtablissementRepository $repository;
    private string $path = '/etablissement/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Etablissement::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Etablissement index');

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
            'etablissement[nom]' => 'Testing',
            'etablissement[tel]' => 'Testing',
            'etablissement[mail]' => 'Testing',
            'etablissement[type]' => 'Testing',
            'etablissement[civiliteResponsable]' => 'Testing',
            'etablissement[nomResponsable]' => 'Testing',
            'etablissement[prenomResponsable]' => 'Testing',
        ]);

        self::assertResponseRedirects('/etablissement/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Etablissement();
        $fixture->setNom('My Title');
        $fixture->setTel('My Title');
        $fixture->setMail('My Title');
        $fixture->setType('My Title');
        $fixture->setCiviliteResponsable('My Title');
        $fixture->setNomResponsable('My Title');
        $fixture->setPrenomResponsable('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Etablissement');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Etablissement();
        $fixture->setNom('My Title');
        $fixture->setTel('My Title');
        $fixture->setMail('My Title');
        $fixture->setType('My Title');
        $fixture->setCiviliteResponsable('My Title');
        $fixture->setNomResponsable('My Title');
        $fixture->setPrenomResponsable('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'etablissement[nom]' => 'Something New',
            'etablissement[tel]' => 'Something New',
            'etablissement[mail]' => 'Something New',
            'etablissement[type]' => 'Something New',
            'etablissement[civiliteResponsable]' => 'Something New',
            'etablissement[nomResponsable]' => 'Something New',
            'etablissement[prenomResponsable]' => 'Something New',
        ]);

        self::assertResponseRedirects('/etablissement/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getTel());
        self::assertSame('Something New', $fixture[0]->getMail());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getCiviliteResponsable());
        self::assertSame('Something New', $fixture[0]->getNomResponsable());
        self::assertSame('Something New', $fixture[0]->getPrenomResponsable());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Etablissement();
        $fixture->setNom('My Title');
        $fixture->setTel('My Title');
        $fixture->setMail('My Title');
        $fixture->setType('My Title');
        $fixture->setCiviliteResponsable('My Title');
        $fixture->setNomResponsable('My Title');
        $fixture->setPrenomResponsable('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/etablissement/');
    }
}
