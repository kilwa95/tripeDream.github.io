<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216170723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voyage_activite DROP FOREIGN KEY FK_993728399B0F88B1');
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D8955A1B93536');
        $this->addSql('ALTER TABLE voyage_pays DROP FOREIGN KEY FK_A40DF420A6E44244');
        $this->addSql('ALTER TABLE voyage_saison DROP FOREIGN KEY FK_F06FBA53F965414C');
        $this->addSql('ALTER TABLE voyage_ville DROP FOREIGN KEY FK_4953E52CA73F0036');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF068C9E5AF');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FF68C9E5AF');
        $this->addSql('ALTER TABLE tarif DROP FOREIGN KEY FK_E7189C968C9E5AF');
        $this->addSql('ALTER TABLE voyage_activite DROP FOREIGN KEY FK_9937283968C9E5AF');
        $this->addSql('ALTER TABLE voyage_pays DROP FOREIGN KEY FK_A40DF42068C9E5AF');
        $this->addSql('ALTER TABLE voyage_saison DROP FOREIGN KEY FK_F06FBA5368C9E5AF');
        $this->addSql('ALTER TABLE voyage_ville DROP FOREIGN KEY FK_4953E52C68C9E5AF');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE info_pratique');
        $this->addSql('DROP TABLE pays');
        $this->addSql('DROP TABLE programme');
        $this->addSql('DROP TABLE saison');
        $this->addSql('DROP TABLE tarif');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE voyage');
        $this->addSql('DROP TABLE voyage_activite');
        $this->addSql('DROP TABLE voyage_pays');
        $this->addSql('DROP TABLE voyage_saison');
        $this->addSql('DROP TABLE voyage_ville');
        $this->addSql('ALTER TABLE user DROP name, DROP prenom');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, rue VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, compliment VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, code_postal INT NOT NULL, ville VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, voyage_id INT DEFAULT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATETIME NOT NULL, INDEX IDX_8F91ABF068C9E5AF (voyage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE info_pratique (id INT AUTO_INCREMENT NOT NULL, rendez_vous DATETIME NOT NULL, fin_sejour DATETIME NOT NULL, hebergement LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, repas LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, covid19 LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pays (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, voyage_id INT DEFAULT NULL, jour INT NOT NULL, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_3DDCB9FF68C9E5AF (voyage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE saison (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tarif (id INT AUTO_INCREMENT NOT NULL, voyage_id INT DEFAULT NULL, prix INT NOT NULL, depart DATETIME NOT NULL, arrive DATETIME NOT NULL, capacite INT NOT NULL, INDEX IDX_E7189C968C9E5AF (voyage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE voyage (id INT AUTO_INCREMENT NOT NULL, info_pratique_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, point_fort LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_3F9D8955A1B93536 (info_pratique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE voyage_activite (voyage_id INT NOT NULL, activite_id INT NOT NULL, INDEX IDX_9937283968C9E5AF (voyage_id), INDEX IDX_993728399B0F88B1 (activite_id), PRIMARY KEY(voyage_id, activite_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE voyage_pays (voyage_id INT NOT NULL, pays_id INT NOT NULL, INDEX IDX_A40DF42068C9E5AF (voyage_id), INDEX IDX_A40DF420A6E44244 (pays_id), PRIMARY KEY(voyage_id, pays_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE voyage_saison (voyage_id INT NOT NULL, saison_id INT NOT NULL, INDEX IDX_F06FBA5368C9E5AF (voyage_id), INDEX IDX_F06FBA53F965414C (saison_id), PRIMARY KEY(voyage_id, saison_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE voyage_ville (voyage_id INT NOT NULL, ville_id INT NOT NULL, INDEX IDX_4953E52C68C9E5AF (voyage_id), INDEX IDX_4953E52CA73F0036 (ville_id), PRIMARY KEY(voyage_id, ville_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF068C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FF68C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE tarif ADD CONSTRAINT FK_E7189C968C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D8955A1B93536 FOREIGN KEY (info_pratique_id) REFERENCES info_pratique (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE voyage_activite ADD CONSTRAINT FK_9937283968C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voyage_activite ADD CONSTRAINT FK_993728399B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voyage_pays ADD CONSTRAINT FK_A40DF42068C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voyage_pays ADD CONSTRAINT FK_A40DF420A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voyage_saison ADD CONSTRAINT FK_F06FBA5368C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voyage_saison ADD CONSTRAINT FK_F06FBA53F965414C FOREIGN KEY (saison_id) REFERENCES saison (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voyage_ville ADD CONSTRAINT FK_4953E52C68C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voyage_ville ADD CONSTRAINT FK_4953E52CA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD prenom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
