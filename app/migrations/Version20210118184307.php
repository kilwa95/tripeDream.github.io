<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210118184307 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis ADD compteur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE favorie ADD user_id INT DEFAULT NULL, ADD voyage_id INT DEFAULT NULL, DROP id_voyage');
        $this->addSql('ALTER TABLE favorie ADD CONSTRAINT FK_7DE77163A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorie ADD CONSTRAINT FK_7DE7716368C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id)');
        $this->addSql('CREATE INDEX IDX_7DE77163A76ED395 ON favorie (user_id)');
        $this->addSql('CREATE INDEX IDX_7DE7716368C9E5AF ON favorie (voyage_id)');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) DEFAULT NULL, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('ALTER TABLE user RENAME INDEX fk_8d93d6494de7dc5c TO IDX_8D93D6494DE7DC5C');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP compteur');
        $this->addSql('ALTER TABLE favorie DROP FOREIGN KEY FK_7DE77163A76ED395');
        $this->addSql('ALTER TABLE favorie DROP FOREIGN KEY FK_7DE7716368C9E5AF');
        $this->addSql('DROP INDEX IDX_7DE77163A76ED395 ON favorie');
        $this->addSql('DROP INDEX IDX_7DE7716368C9E5AF ON favorie');
        $this->addSql('ALTER TABLE favorie ADD id_voyage INT NOT NULL, DROP user_id, DROP voyage_id');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user RENAME INDEX idx_8d93d6494de7dc5c TO FK_8D93D6494DE7DC5C');
    }
}
