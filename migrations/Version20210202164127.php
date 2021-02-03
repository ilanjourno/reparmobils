<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210202164127 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE electronic_electronic_params');
        $this->addSql('ALTER TABLE electronic_params ADD electronic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE electronic_params ADD CONSTRAINT FK_AAC9BC072288CAE FOREIGN KEY (electronic_id) REFERENCES electronic (id)');
        $this->addSql('CREATE INDEX IDX_AAC9BC072288CAE ON electronic_params (electronic_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE electronic_electronic_params (electronic_id INT NOT NULL, electronic_params_id INT NOT NULL, INDEX IDX_CC27F216C9C648BF (electronic_params_id), INDEX IDX_CC27F2162288CAE (electronic_id), PRIMARY KEY(electronic_id, electronic_params_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE electronic_electronic_params ADD CONSTRAINT FK_CC27F2162288CAE FOREIGN KEY (electronic_id) REFERENCES electronic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE electronic_electronic_params ADD CONSTRAINT FK_CC27F216C9C648BF FOREIGN KEY (electronic_params_id) REFERENCES electronic_params (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE electronic_params DROP FOREIGN KEY FK_AAC9BC072288CAE');
        $this->addSql('DROP INDEX IDX_AAC9BC072288CAE ON electronic_params');
        $this->addSql('ALTER TABLE electronic_params DROP electronic_id');
    }
}
