<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124155921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED498614A971');
        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED49FF631228');
        $this->addSql('DROP INDEX IDX_C751ED498614A971 ON attribution');
        $this->addSql('DROP INDEX IDX_C751ED49FF631228 ON attribution');
        $this->addSql('ALTER TABLE attribution ADD offre_id INT DEFAULT NULL, DROP etablissement_id, DROP type_chambre_id');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED494CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('CREATE INDEX IDX_C751ED494CC8505A ON attribution (offre_id)');
        $this->addSql('ALTER TABLE lieu CHANGE code_postal code_postal VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED494CC8505A');
        $this->addSql('DROP INDEX IDX_C751ED494CC8505A ON attribution');
        $this->addSql('ALTER TABLE attribution ADD type_chambre_id INT DEFAULT NULL, CHANGE offre_id etablissement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED498614A971 FOREIGN KEY (type_chambre_id) REFERENCES type_chambre (id)');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED49FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
        $this->addSql('CREATE INDEX IDX_C751ED498614A971 ON attribution (type_chambre_id)');
        $this->addSql('CREATE INDEX IDX_C751ED49FF631228 ON attribution (etablissement_id)');
        $this->addSql('ALTER TABLE lieu CHANGE code_postal code_postal INT NOT NULL');
    }
}
