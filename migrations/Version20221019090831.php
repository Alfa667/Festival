<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221019090831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribution (id INT AUTO_INCREMENT NOT NULL, etablissement_id INT DEFAULT NULL, type_chambre_id INT DEFAULT NULL, groupe_id INT DEFAULT NULL, nombre_chambres INT NOT NULL, INDEX IDX_C751ED49FF631228 (etablissement_id), INDEX IDX_C751ED498614A971 (type_chambre_id), INDEX IDX_C751ED497A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etablissement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, tel VARCHAR(10) NOT NULL, mail VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, civilite_responsable VARCHAR(255) NOT NULL, nom_responsable VARCHAR(255) NOT NULL, prenom_responsable VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, identite_responsable VARCHAR(255) NOT NULL, adresse_postale VARCHAR(255) NOT NULL, nombre_personnes INT NOT NULL, nom_pays VARCHAR(255) NOT NULL, hebergement VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, etablissement_id INT DEFAULT NULL, type_chambre_id INT DEFAULT NULL, nombre_chambres INT NOT NULL, INDEX IDX_AF86866FFF631228 (etablissement_id), INDEX IDX_AF86866F8614A971 (type_chambre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_chambre (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED49FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED498614A971 FOREIGN KEY (type_chambre_id) REFERENCES type_chambre (id)');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED497A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FFF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F8614A971 FOREIGN KEY (type_chambre_id) REFERENCES type_chambre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED49FF631228');
        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED498614A971');
        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED497A45358C');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FFF631228');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F8614A971');
        $this->addSql('DROP TABLE attribution');
        $this->addSql('DROP TABLE etablissement');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE type_chambre');
    }
}
