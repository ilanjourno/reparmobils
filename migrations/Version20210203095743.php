<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203095743 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coupon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, finish_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE electronic (id INT AUTO_INCREMENT NOT NULL, mark_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_1E6F305E4290F12B (mark_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE electronic_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE electronic_params (id INT AUTO_INCREMENT NOT NULL, electronic_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, multiple_or_not TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_AAC9BC072288CAE (electronic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE electronic_params_values (id INT AUTO_INCREMENT NOT NULL, param_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, nickname VARCHAR(255) DEFAULT NULL, INDEX IDX_ADE8352E5647C863 (param_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, file VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_63540594584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mark (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_emails (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, price DOUBLE PRECISION NOT NULL, complet_description LONGTEXT DEFAULT NULL, quantity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_electronic (product_id INT NOT NULL, electronic_id INT NOT NULL, INDEX IDX_8D086F754584665A (product_id), INDEX IDX_8D086F752288CAE (electronic_id), PRIMARY KEY(product_id, electronic_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE electronic ADD CONSTRAINT FK_1E6F305E4290F12B FOREIGN KEY (mark_id) REFERENCES mark (id)');
        $this->addSql('ALTER TABLE electronic_params ADD CONSTRAINT FK_AAC9BC072288CAE FOREIGN KEY (electronic_id) REFERENCES electronic (id)');
        $this->addSql('ALTER TABLE electronic_params_values ADD CONSTRAINT FK_ADE8352E5647C863 FOREIGN KEY (param_id) REFERENCES electronic_params (id)');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_63540594584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_electronic ADD CONSTRAINT FK_8D086F754584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_electronic ADD CONSTRAINT FK_8D086F752288CAE FOREIGN KEY (electronic_id) REFERENCES electronic (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE electronic_params DROP FOREIGN KEY FK_AAC9BC072288CAE');
        $this->addSql('ALTER TABLE product_electronic DROP FOREIGN KEY FK_8D086F752288CAE');
        $this->addSql('ALTER TABLE electronic_params_values DROP FOREIGN KEY FK_ADE8352E5647C863');
        $this->addSql('ALTER TABLE electronic DROP FOREIGN KEY FK_1E6F305E4290F12B');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_63540594584665A');
        $this->addSql('ALTER TABLE product_electronic DROP FOREIGN KEY FK_8D086F754584665A');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE electronic');
        $this->addSql('DROP TABLE electronic_category');
        $this->addSql('DROP TABLE electronic_params');
        $this->addSql('DROP TABLE electronic_params_values');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE mark');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE newsletter_emails');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_electronic');
        $this->addSql('DROP TABLE user');
    }
}
