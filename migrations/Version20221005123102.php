<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221005123102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_7b00651c1420fd7');
        $this->addSql('ALTER TABLE status ADD project_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE status ADD name VARCHAR(255)');
        $this->addSql('ALTER TABLE status RENAME COLUMN ticket_status TO label');
        $this->addSql('ALTER TABLE status RENAME COLUMN ticket_order TO order_index');
        $this->addSql('COMMENT ON COLUMN status.project_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE status ADD CONSTRAINT FK_7B00651C166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7B00651C166D1F9C ON status (project_id)');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE status DROP CONSTRAINT FK_7B00651C166D1F9C');
        $this->addSql('DROP INDEX IDX_7B00651C166D1F9C');
        $this->addSql('ALTER TABLE status ADD ticket_status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE status DROP project_id');
        $this->addSql('ALTER TABLE status DROP label');
        $this->addSql('ALTER TABLE status DROP name');
        $this->addSql('ALTER TABLE status RENAME COLUMN order_index TO ticket_order');
        $this->addSql('CREATE UNIQUE INDEX uniq_7b00651c1420fd7 ON status (ticket_status)');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64935049EF7');
        $this->addSql('DROP INDEX IDX_8D93D64935049EF7');
        $this->addSql('DROP INDEX "primary"');
    }
}
