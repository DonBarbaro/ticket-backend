<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221011074827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id UUID NOT NULL, author_id UUID DEFAULT NULL, parent_id UUID DEFAULT NULL, ticket_id UUID DEFAULT NULL, comment_message VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
        $this->addSql('CREATE INDEX IDX_9474526C727ACA70 ON comment (parent_id)');
        $this->addSql('CREATE INDEX IDX_9474526C700047D2 ON comment (ticket_id)');
        $this->addSql('COMMENT ON COLUMN comment.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN comment.author_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN comment.parent_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN comment.ticket_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C727ACA70 FOREIGN KEY (parent_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE status ALTER name SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C727ACA70');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C700047D2');
        $this->addSql('DROP TABLE comment');
        $this->addSql('ALTER TABLE status ALTER name DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64935049EF7');
        $this->addSql('DROP INDEX IDX_8D93D64935049EF7');
        $this->addSql('DROP INDEX "primary"');
    }
}
