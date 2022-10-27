<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221027103209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ticket_history (id UUID NOT NULL, event VARCHAR(255) NOT NULL, payload VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ticket_ticket_histories (ticket_id UUID NOT NULL, ticket_histories_id UUID NOT NULL, PRIMARY KEY(ticket_id, ticket_histories_id))');
        $this->addSql('CREATE INDEX IDX_3F79A070700047D2 ON ticket_ticket_histories (ticket_id)');
        $this->addSql('CREATE INDEX IDX_3F79A070E26AE227 ON ticket_ticket_histories (ticket_histories_id)');
        $this->addSql('CREATE TABLE user_ticket_histories (user_id UUID NOT NULL, user_histories_id UUID NOT NULL, PRIMARY KEY(user_id, user_histories_id))');
        $this->addSql('CREATE INDEX IDX_28DE5634A76ED395 ON user_ticket_histories (user_id)');
        $this->addSql('CREATE INDEX IDX_28DE5634A270628E ON user_ticket_histories (user_histories_id)');
        $this->addSql('ALTER TABLE ticket_ticket_histories ADD CONSTRAINT FK_3F79A070700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket_history (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket_ticket_histories ADD CONSTRAINT FK_3F79A070E26AE227 FOREIGN KEY (ticket_histories_id) REFERENCES ticket (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_ticket_histories ADD CONSTRAINT FK_28DE5634A76ED395 FOREIGN KEY (user_id) REFERENCES ticket_history (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_ticket_histories ADD CONSTRAINT FK_28DE5634A270628E FOREIGN KEY (user_histories_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs;
        $this->addSql('ALTER TABLE ticket_ticket_histories DROP CONSTRAINT FK_3F79A070700047D2');
        $this->addSql('ALTER TABLE ticket_ticket_histories DROP CONSTRAINT FK_3F79A070E26AE227');
        $this->addSql('ALTER TABLE user_ticket_histories DROP CONSTRAINT FK_28DE5634A76ED395');
        $this->addSql('ALTER TABLE user_ticket_histories DROP CONSTRAINT FK_28DE5634A270628E');
        $this->addSql('DROP TABLE ticket_history');
        $this->addSql('DROP TABLE ticket_ticket_histories');
        $this->addSql('DROP TABLE user_ticket_histories');
    }
}
