<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210202160500 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE electronic_electronic_params (electronic_id INT NOT NULL, electronic_params_id INT NOT NULL, INDEX IDX_CC27F2162288CAE (electronic_id), INDEX IDX_CC27F216C9C648BF (electronic_params_id), PRIMARY KEY(electronic_id, electronic_params_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE electronic_params (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, multiple_or_not TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE electronic_params_values (id INT AUTO_INCREMENT NOT NULL, param_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_ADE8352E5647C863 (param_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE electronic_electronic_params ADD CONSTRAINT FK_CC27F2162288CAE FOREIGN KEY (electronic_id) REFERENCES electronic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE electronic_electronic_params ADD CONSTRAINT FK_CC27F216C9C648BF FOREIGN KEY (electronic_params_id) REFERENCES electronic_params (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE electronic_params_values ADD CONSTRAINT FK_ADE8352E5647C863 FOREIGN KEY (param_id) REFERENCES electronic_params (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE electronic_electronic_params DROP FOREIGN KEY FK_CC27F216C9C648BF');
        $this->addSql('ALTER TABLE electronic_params_values DROP FOREIGN KEY FK_ADE8352E5647C863');
        $this->addSql('DROP TABLE electronic_electronic_params');
        $this->addSql('DROP TABLE electronic_params');
        $this->addSql('DROP TABLE electronic_params_values');
    }
}
