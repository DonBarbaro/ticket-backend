<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220930090601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE status_ticket_settings (status_id UUID NOT NULL, ticket_settings_id UUID NOT NULL, PRIMARY KEY(status_id, ticket_settings_id))');
        $this->addSql('CREATE INDEX IDX_70766EB16BF700BD ON status_ticket_settings (status_id)');
        $this->addSql('CREATE INDEX IDX_70766EB135049EF7 ON status_ticket_settings (ticket_settings_id)');
        $this->addSql('COMMENT ON COLUMN status_ticket_settings.status_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN status_ticket_settings.ticket_settings_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE ticket_ticket_settings (ticket_id UUID NOT NULL, ticket_settings_id UUID NOT NULL, PRIMARY KEY(ticket_id, ticket_settings_id))');
        $this->addSql('CREATE INDEX IDX_62B83755700047D2 ON ticket_ticket_settings (ticket_id)');
        $this->addSql('CREATE INDEX IDX_62B8375535049EF7 ON ticket_ticket_settings (ticket_settings_id)');
        $this->addSql('COMMENT ON COLUMN ticket_ticket_settings.ticket_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN ticket_ticket_settings.ticket_settings_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE status_ticket_settings ADD CONSTRAINT FK_70766EB16BF700BD FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE status_ticket_settings ADD CONSTRAINT FK_70766EB135049EF7 FOREIGN KEY (ticket_settings_id) REFERENCES ticket_settings (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket_ticket_settings ADD CONSTRAINT FK_62B83755700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket_ticket_settings ADD CONSTRAINT FK_62B8375535049EF7 FOREIGN KEY (ticket_settings_id) REFERENCES ticket_settings (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket_settings DROP CONSTRAINT fk_602c5c447e3c61f9');
        $this->addSql('ALTER TABLE ticket_settings DROP CONSTRAINT fk_602c5c44700047d2');
        $this->addSql('ALTER TABLE ticket_settings DROP CONSTRAINT fk_602c5c446bf700bd');
        $this->addSql('DROP INDEX uniq_602c5c447e3c61f9');
        $this->addSql('DROP INDEX uniq_602c5c44700047d2');
        $this->addSql('DROP INDEX uniq_602c5c446bf700bd');
        $this->addSql('ALTER TABLE ticket_settings DROP status_id');
        $this->addSql('ALTER TABLE ticket_settings DROP owner_id');
        $this->addSql('ALTER TABLE ticket_settings DROP ticket_id');
        $this->addSql('ALTER TABLE "user" ADD ticket_settings_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN "user".ticket_settings_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D64935049EF7 FOREIGN KEY (ticket_settings_id) REFERENCES ticket_settings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D64935049EF7 ON "user" (ticket_settings_id)');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE status_ticket_settings DROP CONSTRAINT FK_70766EB16BF700BD');
        $this->addSql('ALTER TABLE status_ticket_settings DROP CONSTRAINT FK_70766EB135049EF7');
        $this->addSql('ALTER TABLE ticket_ticket_settings DROP CONSTRAINT FK_62B83755700047D2');
        $this->addSql('ALTER TABLE ticket_ticket_settings DROP CONSTRAINT FK_62B8375535049EF7');
        $this->addSql('DROP TABLE status_ticket_settings');
        $this->addSql('DROP TABLE ticket_ticket_settings');
        $this->addSql('ALTER TABLE ticket_settings ADD status_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket_settings ADD owner_id UUID NOT NULL');
        $this->addSql('ALTER TABLE ticket_settings ADD ticket_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN ticket_settings.status_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN ticket_settings.owner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN ticket_settings.ticket_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE ticket_settings ADD CONSTRAINT fk_602c5c447e3c61f9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket_settings ADD CONSTRAINT fk_602c5c44700047d2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket_settings ADD CONSTRAINT fk_602c5c446bf700bd FOREIGN KEY (status_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_602c5c447e3c61f9 ON ticket_settings (owner_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_602c5c44700047d2 ON ticket_settings (ticket_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_602c5c446bf700bd ON ticket_settings (status_id)');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64935049EF7');
        $this->addSql('DROP INDEX IDX_8D93D64935049EF7');
        $this->addSql('DROP INDEX "primary"');
        $this->addSql('ALTER TABLE "user" DROP ticket_settings_id');
    }
}
