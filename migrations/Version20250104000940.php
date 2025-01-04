<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250104000940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP CONSTRAINT fk_5f9e962a63379586');
        $this->addSql('DROP INDEX idx_5f9e962a63379586');
        $this->addSql('ALTER TABLE comments DROP comments_id');
        $this->addSql('ALTER TABLE comments DROP is_reply');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE comments ADD comments_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comments ADD is_reply BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT fk_5f9e962a63379586 FOREIGN KEY (comments_id) REFERENCES comments (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5f9e962a63379586 ON comments (comments_id)');
    }
}
