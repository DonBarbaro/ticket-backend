<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220826131826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_project DROP CONSTRAINT fk_77becee4a76ed395');
        $this->addSql('ALTER TABLE user_project DROP CONSTRAINT fk_77becee4166d1f9c');
        $this->addSql('DROP TABLE user_project');
        $this->addSql('ALTER TABLE ticket DROP note');
        $this->addSql('ALTER TABLE "user" ADD notification_settings_telegram_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD notification_settings_telegram_varified BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD notification_settings_email_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD notification_settings_email_varified BOOLEAN NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_project (user_id UUID NOT NULL, project_id UUID NOT NULL, PRIMARY KEY(user_id, project_id))');
        $this->addSql('CREATE INDEX idx_77becee4a76ed395 ON user_project (user_id)');
        $this->addSql('CREATE INDEX idx_77becee4166d1f9c ON user_project (project_id)');
        $this->addSql('COMMENT ON COLUMN user_project.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_project.project_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user_project ADD CONSTRAINT fk_77becee4a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_project ADD CONSTRAINT fk_77becee4166d1f9c FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" DROP notification_settings_telegram_id');
        $this->addSql('ALTER TABLE "user" DROP notification_settings_telegram_varified');
        $this->addSql('ALTER TABLE "user" DROP notification_settings_email_id');
        $this->addSql('ALTER TABLE "user" DROP notification_settings_email_varified');
        $this->addSql('ALTER TABLE ticket ADD note VARCHAR(255) DEFAULT NULL');
    }
}
