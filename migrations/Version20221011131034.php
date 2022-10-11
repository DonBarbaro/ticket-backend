<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221011131034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket_ticket_settings DROP CONSTRAINT fk_62b83755700047d2');
        $this->addSql('ALTER TABLE ticket_ticket_settings DROP CONSTRAINT fk_62b8375535049ef7');
        $this->addSql('ALTER TABLE status_ticket_settings DROP CONSTRAINT fk_70766eb16bf700bd');
        $this->addSql('ALTER TABLE status_ticket_settings DROP CONSTRAINT fk_70766eb135049ef7');
        $this->addSql('DROP TABLE ticket_ticket_settings');
        $this->addSql('DROP TABLE status_ticket_settings');
        $this->addSql('ALTER TABLE status ADD ticket_settings_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE status ALTER name SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN status.ticket_settings_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C35049EF7 FOREIGN KEY (ticket_settings_id) REFERENCES ticket_settings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7B00651C35049EF7 ON status (ticket_settings_id)');
        $this->addSql('ALTER TABLE ticket ADD ticket_settings_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN ticket.ticket_settings_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA335049EF7 FOREIGN KEY (ticket_settings_id) REFERENCES ticket_settings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_97A0ADA335049EF7 ON ticket (ticket_settings_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ticket_ticket_settings (ticket_id UUID NOT NULL, ticket_settings_id UUID NOT NULL, PRIMARY KEY(ticket_id, ticket_settings_id))');
        $this->addSql('CREATE INDEX idx_62b83755700047d2 ON ticket_ticket_settings (ticket_id)');
        $this->addSql('CREATE INDEX idx_62b8375535049ef7 ON ticket_ticket_settings (ticket_settings_id)');
        $this->addSql('COMMENT ON COLUMN ticket_ticket_settings.ticket_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN ticket_ticket_settings.ticket_settings_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE status_ticket_settings (status_id UUID NOT NULL, ticket_settings_id UUID NOT NULL, PRIMARY KEY(status_id, ticket_settings_id))');
        $this->addSql('CREATE INDEX idx_70766eb16bf700bd ON status_ticket_settings (status_id)');
        $this->addSql('CREATE INDEX idx_70766eb135049ef7 ON status_ticket_settings (ticket_settings_id)');
        $this->addSql('COMMENT ON COLUMN status_ticket_settings.status_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN status_ticket_settings.ticket_settings_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE ticket_ticket_settings ADD CONSTRAINT fk_62b83755700047d2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket_ticket_settings ADD CONSTRAINT fk_62b8375535049ef7 FOREIGN KEY (ticket_settings_id) REFERENCES ticket_settings (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE status_ticket_settings ADD CONSTRAINT fk_70766eb16bf700bd FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE status_ticket_settings ADD CONSTRAINT fk_70766eb135049ef7 FOREIGN KEY (ticket_settings_id) REFERENCES ticket_settings (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE status DROP CONSTRAINT FK_7B00651C35049EF7');
        $this->addSql('DROP INDEX IDX_7B00651C35049EF7');
        $this->addSql('ALTER TABLE status DROP ticket_settings_id');
        $this->addSql('ALTER TABLE status ALTER name DROP NOT NULL');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA335049EF7');
        $this->addSql('DROP INDEX IDX_97A0ADA335049EF7');
        $this->addSql('ALTER TABLE ticket DROP ticket_settings_id');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64935049EF7');
        $this->addSql('DROP INDEX IDX_8D93D64935049EF7');
        $this->addSql('DROP INDEX "primary"');
    }
}
