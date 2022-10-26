<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220919111245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE status (id UUID NOT NULL, ticket_status VARCHAR(255) NOT NULL, ticket_order INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7B00651C1420FD7 ON status (ticket_status)');
        $this->addSql('COMMENT ON COLUMN status.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE ticket_settings (id UUID NOT NULL, status_id UUID DEFAULT NULL, owner_id UUID NOT NULL, ticket_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_602C5C446BF700BD ON ticket_settings (status_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_602C5C447E3C61F9 ON ticket_settings (owner_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_602C5C44700047D2 ON ticket_settings (ticket_id)');
        $this->addSql('COMMENT ON COLUMN ticket_settings.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN ticket_settings.status_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN ticket_settings.owner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN ticket_settings.ticket_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE ticket_settings ADD CONSTRAINT FK_602C5C446BF700BD FOREIGN KEY (status_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket_settings ADD CONSTRAINT FK_602C5C447E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket_settings ADD CONSTRAINT FK_602C5C44700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket_settings ADD email BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket_settings ADD telegram BOOLEAN DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket_settings DROP CONSTRAINT FK_602C5C446BF700BD');
        $this->addSql('ALTER TABLE ticket_settings DROP CONSTRAINT FK_602C5C447E3C61F9');
        $this->addSql('ALTER TABLE ticket_settings DROP CONSTRAINT FK_602C5C44700047D2');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE ticket_settings');
        $this->addSql('ALTER TABLE ticket_settings DROP email');
        $this->addSql('ALTER TABLE ticket_settings DROP telegram');
    }
}
