<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210202152826 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_electronics DROP FOREIGN KEY FK_3BEC42D7D61D1B46');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('CREATE TABLE electronic (id INT AUTO_INCREMENT NOT NULL, mark_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, colors LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_1E6F305E4290F12B (mark_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE electronic_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_electronic (product_id INT NOT NULL, electronic_id INT NOT NULL, INDEX IDX_8D086F754584665A (product_id), INDEX IDX_8D086F752288CAE (electronic_id), PRIMARY KEY(product_id, electronic_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE electronic ADD CONSTRAINT FK_1E6F305E4290F12B FOREIGN KEY (mark_id) REFERENCES mark (id)');
        $this->addSql('ALTER TABLE product_electronic ADD CONSTRAINT FK_8D086F754584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_electronic ADD CONSTRAINT FK_8D086F752288CAE FOREIGN KEY (electronic_id) REFERENCES electronic (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE electronics');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('DROP TABLE product_electronics');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('ALTER TABLE product DROP category_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_electronic DROP FOREIGN KEY FK_8D086F752288CAE');
        $this->addSql('CREATE TABLE electronics (id INT AUTO_INCREMENT NOT NULL, mark_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, colors LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_97C3DCC84290F12B (mark_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product_electronics (product_id INT NOT NULL, electronics_id INT NOT NULL, INDEX IDX_3BEC42D74584665A (product_id), INDEX IDX_3BEC42D7D61D1B46 (electronics_id), PRIMARY KEY(product_id, electronics_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE electronics ADD CONSTRAINT FK_97C3DCC84290F12B FOREIGN KEY (mark_id) REFERENCES mark (id)');
        $this->addSql('ALTER TABLE product_electronics ADD CONSTRAINT FK_3BEC42D74584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_electronics ADD CONSTRAINT FK_3BEC42D7D61D1B46 FOREIGN KEY (electronics_id) REFERENCES electronics (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE electronic');
        $this->addSql('DROP TABLE electronic_category');
        $this->addSql('DROP TABLE product_electronic');
        $this->addSql('ALTER TABLE product ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES product_category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
    }
}
