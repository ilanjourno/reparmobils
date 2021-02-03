<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210131145238 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE phone_phone (phone_source INT NOT NULL, phone_target INT NOT NULL, INDEX IDX_B715E2C7A21BDC7C (phone_source), INDEX IDX_B715E2C7BBFE8CF3 (phone_target), PRIMARY KEY(phone_source, phone_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE phone_phone ADD CONSTRAINT FK_B715E2C7A21BDC7C FOREIGN KEY (phone_source) REFERENCES phone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE phone_phone ADD CONSTRAINT FK_B715E2C7BBFE8CF3 FOREIGN KEY (phone_target) REFERENCES phone (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE phone_phone');
    }
}
