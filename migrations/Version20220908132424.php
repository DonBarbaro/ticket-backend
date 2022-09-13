<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220908132424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD notification_settings_telegram_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD notification_settings_telegram_verified BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD notification_settings_email_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD notification_settings_email_verified BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD notification_settings_push BOOLEAN NOT NULL');
        $this->addSql('CREATE TABLE user_project (user_id UUID NOT NULL, project_id UUID NOT NULL, PRIMARY KEY(user_id, project_id))');
        $this->addSql('CREATE INDEX IDX_77BECEE4A76ED395 ON user_project (user_id)');
        $this->addSql('CREATE INDEX IDX_77BECEE4166D1F9C ON user_project (project_id)');
        $this->addSql('ALTER TABLE user_project ADD CONSTRAINT FK_77BECEE4A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_project ADD CONSTRAINT FK_77BECEE4166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "user" DROP notification_settings_telegram_id');
        $this->addSql('ALTER TABLE "user" DROP notification_settings_telegram_verified');
        $this->addSql('ALTER TABLE "user" DROP notification_settings_email_id');
        $this->addSql('ALTER TABLE "user" DROP notification_settings_email_verified');
        $this->addSql('ALTER TABLE "user" DROP notification_settings_push');
        $this->addSql('ALTER TABLE user_project DROP CONSTRAINT FK_77BECEE4A76ED395');
        $this->addSql('ALTER TABLE user_project DROP CONSTRAINT FK_77BECEE4166D1F9C');
        $this->addSql('DROP TABLE user_project');
    }
}
