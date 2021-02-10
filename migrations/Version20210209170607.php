<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210209170607 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(200) NOT NULL, country_tag VARCHAR(2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, departure_id INT NOT NULL, arrival_id INT NOT NULL, number VARCHAR(200) NOT NULL, departure_date DATETIME NOT NULL, arrival_date DATETIME NOT NULL, seat VARCHAR(200) DEFAULT NULL, gate VARCHAR(200) DEFAULT NULL, baggage_drop VARCHAR(200) DEFAULT NULL, INDEX IDX_C27C9369C54C8C93 (type_id), INDEX IDX_C27C93697704ED06 (departure_id), INDEX IDX_C27C936962789708 (arrival_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE travel (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(200) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE travel_stage (travel_id INT NOT NULL, stage_id INT NOT NULL, INDEX IDX_6AD014DFECAB15B3 (travel_id), INDEX IDX_6AD014DF2298D193 (stage_id), PRIMARY KEY(travel_id, stage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(200) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C93697704ED06 FOREIGN KEY (departure_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C936962789708 FOREIGN KEY (arrival_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE travel_stage ADD CONSTRAINT FK_6AD014DFECAB15B3 FOREIGN KEY (travel_id) REFERENCES travel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE travel_stage ADD CONSTRAINT FK_6AD014DF2298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C93697704ED06');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C936962789708');
        $this->addSql('ALTER TABLE travel_stage DROP FOREIGN KEY FK_6AD014DF2298D193');
        $this->addSql('ALTER TABLE travel_stage DROP FOREIGN KEY FK_6AD014DFECAB15B3');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369C54C8C93');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE travel');
        $this->addSql('DROP TABLE travel_stage');
        $this->addSql('DROP TABLE type');
    }
}
