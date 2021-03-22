<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210322115834 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE walk (id INT AUTO_INCREMENT NOT NULL, area_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, starting_point VARCHAR(255) NOT NULL, end_point VARCHAR(255) NOT NULL, date DATETIME NOT NULL, duration VARCHAR(64) NOT NULL, difficulty VARCHAR(128) NOT NULL, elevation INT DEFAULT NULL, max_nb_persons SMALLINT DEFAULT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8D917A55BD0F409C (area_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE walk ADD CONSTRAINT FK_8D917A55BD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE walk');
    }
}
