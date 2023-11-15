<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231115134432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE post_like_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE "PostLikes_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "PostLikes" (id INT NOT NULL, is_liked_by_id INT NOT NULL, post_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9E8AF4CA650443B7 ON "PostLikes" (is_liked_by_id)');
        $this->addSql('CREATE INDEX IDX_9E8AF4CA4B89032C ON "PostLikes" (post_id)');
        $this->addSql('ALTER TABLE "PostLikes" ADD CONSTRAINT FK_9E8AF4CA650443B7 FOREIGN KEY (is_liked_by_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "PostLikes" ADD CONSTRAINT FK_9E8AF4CA4B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post_like DROP CONSTRAINT fk_653627b8650443b7');
        $this->addSql('ALTER TABLE post_like DROP CONSTRAINT fk_653627b84b89032c');
        $this->addSql('DROP TABLE post_like');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "PostLikes_id_seq" CASCADE');
        $this->addSql('CREATE SEQUENCE post_like_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE post_like (id INT NOT NULL, is_liked_by_id INT NOT NULL, post_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_653627b84b89032c ON post_like (post_id)');
        $this->addSql('CREATE INDEX idx_653627b8650443b7 ON post_like (is_liked_by_id)');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT fk_653627b8650443b7 FOREIGN KEY (is_liked_by_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT fk_653627b84b89032c FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "PostLikes" DROP CONSTRAINT FK_9E8AF4CA650443B7');
        $this->addSql('ALTER TABLE "PostLikes" DROP CONSTRAINT FK_9E8AF4CA4B89032C');
        $this->addSql('DROP TABLE "PostLikes"');
    }
}
