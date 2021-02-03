<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210131114723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE phone ADD mark_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE phone ADD CONSTRAINT FK_444F97DD4290F12B FOREIGN KEY (mark_id) REFERENCES mark (id)');
        $this->addSql('CREATE INDEX IDX_444F97DD4290F12B ON phone (mark_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4290F12B');
        $this->addSql('DROP INDEX IDX_D34A04AD4290F12B ON product');
        $this->addSql('ALTER TABLE product DROP mark_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE phone DROP FOREIGN KEY FK_444F97DD4290F12B');
        $this->addSql('DROP INDEX IDX_444F97DD4290F12B ON phone');
        $this->addSql('ALTER TABLE phone DROP mark_id');
        $this->addSql('ALTER TABLE product ADD mark_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4290F12B FOREIGN KEY (mark_id) REFERENCES mark (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD4290F12B ON product (mark_id)');
    }
}
