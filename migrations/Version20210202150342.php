<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210202150342 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_phone DROP FOREIGN KEY FK_E513EC813B7323CB');
        $this->addSql('CREATE TABLE coupon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, finish_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE electronics (id INT AUTO_INCREMENT NOT NULL, mark_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, colors LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_97C3DCC84290F12B (mark_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_electronics (product_id INT NOT NULL, electronics_id INT NOT NULL, INDEX IDX_3BEC42D74584665A (product_id), INDEX IDX_3BEC42D7D61D1B46 (electronics_id), PRIMARY KEY(product_id, electronics_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE electronics ADD CONSTRAINT FK_97C3DCC84290F12B FOREIGN KEY (mark_id) REFERENCES mark (id)');
        $this->addSql('ALTER TABLE product_electronics ADD CONSTRAINT FK_3BEC42D74584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_electronics ADD CONSTRAINT FK_3BEC42D7D61D1B46 FOREIGN KEY (electronics_id) REFERENCES electronics (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE phone');
        $this->addSql('DROP TABLE product_phone');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_electronics DROP FOREIGN KEY FK_3BEC42D7D61D1B46');
        $this->addSql('CREATE TABLE phone (id INT AUTO_INCREMENT NOT NULL, mark_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, colors LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_444F97DD4290F12B (mark_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product_phone (product_id INT NOT NULL, phone_id INT NOT NULL, INDEX IDX_E513EC814584665A (product_id), INDEX IDX_E513EC813B7323CB (phone_id), PRIMARY KEY(product_id, phone_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE phone ADD CONSTRAINT FK_444F97DD4290F12B FOREIGN KEY (mark_id) REFERENCES mark (id)');
        $this->addSql('ALTER TABLE product_phone ADD CONSTRAINT FK_E513EC813B7323CB FOREIGN KEY (phone_id) REFERENCES phone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_phone ADD CONSTRAINT FK_E513EC814584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE electronics');
        $this->addSql('DROP TABLE product_electronics');
    }
}
