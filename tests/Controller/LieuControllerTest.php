<?php

namespace App\Test\Controller;

use App\Entity\Lieu;
use App\Repository\LieuRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LieuControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private LieuRepository $repository;
    private string $path = '/lieu/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Lieu::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Lieu index');

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
            'lieu[adresseRue]' => 'Testing',
            'lieu[codePostal]' => 'Testing',
            'lieu[ville]' => 'Testing',
        ]);

        self::assertResponseRedirects('/lieu/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Lieu();
        $fixture->setAdresseRue('My Title');
        $fixture->setCodePostal('My Title');
        $fixture->setVille('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Lieu');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Lieu();
        $fixture->setAdresseRue('My Title');
        $fixture->setCodePostal('My Title');
        $fixture->setVille('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'lieu[adresseRue]' => 'Something New',
            'lieu[codePostal]' => 'Something New',
            'lieu[ville]' => 'Something New',
        ]);

        self::assertResponseRedirects('/lieu/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getAdresseRue());
        self::assertSame('Something New', $fixture[0]->getCodePostal());
        self::assertSame('Something New', $fixture[0]->getVille());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Lieu();
        $fixture->setAdresseRue('My Title');
        $fixture->setCodePostal('My Title');
        $fixture->setVille('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/lieu/');
    }
}
