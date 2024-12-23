<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241220160318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT fk_9474526ca76ed395');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT fk_5a8a6c8da76ed395');
        $this->addSql('ALTER TABLE conversation DROP CONSTRAINT fk_8a8e26e956ae248b');
        $this->addSql('ALTER TABLE conversation DROP CONSTRAINT fk_8a8e26e9441b8b65');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT fk_b6bd307ff624b39d');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT fk_b6bd307fcd53edb6');
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT fk_ac6340b3a76ed395');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('CREATE TABLE "users" (id SERIAL NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON "users" (username)');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE conversation DROP CONSTRAINT FK_8A8E26E956AE248B');
        $this->addSql('ALTER TABLE conversation DROP CONSTRAINT FK_8A8E26E9441B8B65');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E956AE248B FOREIGN KEY (user1_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9441B8B65 FOREIGN KEY (user2_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT FK_AC6340B3A76ED395');
        $this->addSql('ALTER TABLE "like" ADD CONSTRAINT FK_AC6340B3A76ED395 FOREIGN KEY (user_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FCD53EDB6');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8DA76ED395');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE conversation DROP CONSTRAINT FK_8A8E26E956AE248B');
        $this->addSql('ALTER TABLE conversation DROP CONSTRAINT FK_8A8E26E9441B8B65');
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT FK_AC6340B3A76ED395');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FCD53EDB6');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8DA76ED395');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_identifier_username ON "user" (username)');
        $this->addSql('DROP TABLE "users"');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT fk_9474526ca76ed395');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526ca76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT fk_5a8a6c8da76ed395');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT fk_5a8a6c8da76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE conversation DROP CONSTRAINT fk_8a8e26e956ae248b');
        $this->addSql('ALTER TABLE conversation DROP CONSTRAINT fk_8a8e26e9441b8b65');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT fk_8a8e26e956ae248b FOREIGN KEY (user1_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT fk_8a8e26e9441b8b65 FOREIGN KEY (user2_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT fk_b6bd307ff624b39d');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT fk_b6bd307fcd53edb6');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT fk_b6bd307ff624b39d FOREIGN KEY (sender_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT fk_b6bd307fcd53edb6 FOREIGN KEY (receiver_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "like" DROP CONSTRAINT fk_ac6340b3a76ed395');
        $this->addSql('ALTER TABLE "like" ADD CONSTRAINT fk_ac6340b3a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
