<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210326095012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE area (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, color VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, walk_id INT DEFAULT NULL, request_status VARCHAR(64) NOT NULL, INDEX IDX_D79F6B11A76ED395 (user_id), INDEX IDX_D79F6B115EEE1B48 (walk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, area_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(64) NOT NULL, lastname VARCHAR(64) NOT NULL, nickname VARCHAR(255) NOT NULL, date_of_birth DATETIME DEFAULT NULL, picture LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, status SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649BD0F409C (area_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE walk (id INT AUTO_INCREMENT NOT NULL, area_id INT DEFAULT NULL, creator_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, starting_point VARCHAR(255) NOT NULL, end_point VARCHAR(255) NOT NULL, date DATETIME NOT NULL, duration VARCHAR(64) NOT NULL, difficulty VARCHAR(128) NOT NULL, elevation INT DEFAULT NULL, max_nb_persons SMALLINT DEFAULT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8D917A55BD0F409C (area_id), INDEX IDX_8D917A5561220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B115EEE1B48 FOREIGN KEY (walk_id) REFERENCES walk (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('ALTER TABLE walk ADD CONSTRAINT FK_8D917A55BD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('ALTER TABLE walk ADD CONSTRAINT FK_8D917A5561220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BD0F409C');
        $this->addSql('ALTER TABLE walk DROP FOREIGN KEY FK_8D917A55BD0F409C');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11A76ED395');
        $this->addSql('ALTER TABLE walk DROP FOREIGN KEY FK_8D917A5561220EA6');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B115EEE1B48');
        $this->addSql('DROP TABLE area');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE walk');
    }
}
