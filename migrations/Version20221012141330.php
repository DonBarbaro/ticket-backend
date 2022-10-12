<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221012141330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket ADD status_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket DROP status');
        $this->addSql('COMMENT ON COLUMN ticket.status_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA36BF700BD FOREIGN KEY (status_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_97A0ADA36BF700BD ON ticket (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX "primary"');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA36BF700BD');
        $this->addSql('DROP INDEX IDX_97A0ADA36BF700BD');
        $this->addSql('ALTER TABLE ticket ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ticket DROP status_id');
    }
}
