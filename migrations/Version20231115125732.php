<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231115125732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE grade_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE key_activation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE link_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE link_name_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE post_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE post_like_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE report_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE repost_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reset_password_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE role_in_school_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, author_id INT NOT NULL, post_id INT NOT NULL, content VARCHAR(255) NOT NULL, is_edited BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
        $this->addSql('CREATE INDEX IDX_9474526C4B89032C ON comment (post_id)');
        $this->addSql('COMMENT ON COLUMN comment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE grade (id INT NOT NULL, grade_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE key_activation (id INT NOT NULL, key TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE link (id INT NOT NULL, link_name_id INT NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_36AC99F1C71C623 ON link (link_name_id)');
        $this->addSql('CREATE TABLE link_name (id INT NOT NULL, link_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE post (id INT NOT NULL, author_id INT NOT NULL, title TEXT NOT NULL, content TEXT NOT NULL, is_edited BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF675F31B ON post (author_id)');
        $this->addSql('COMMENT ON COLUMN post.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE post_like (id INT NOT NULL, is_liked_by_id INT NOT NULL, post_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_653627B8650443B7 ON post_like (is_liked_by_id)');
        $this->addSql('CREATE INDEX IDX_653627B84B89032C ON post_like (post_id)');
        $this->addSql('CREATE TABLE profile (id INT NOT NULL, grade_id INT DEFAULT NULL, status BOOLEAN NOT NULL, description VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8157AA0FFE19A1A8 ON profile (grade_id)');
        $this->addSql('CREATE TABLE profile_profile (profile_source INT NOT NULL, profile_target INT NOT NULL, PRIMARY KEY(profile_source, profile_target))');
        $this->addSql('CREATE INDEX IDX_52E9749337A01814 ON profile_profile (profile_source)');
        $this->addSql('CREATE INDEX IDX_52E974932E45489B ON profile_profile (profile_target)');
        $this->addSql('CREATE TABLE report (id INT NOT NULL, post_id INT DEFAULT NULL, author_id INT NOT NULL, comment_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C42F77844B89032C ON report (post_id)');
        $this->addSql('CREATE INDEX IDX_C42F7784F675F31B ON report (author_id)');
        $this->addSql('CREATE INDEX IDX_C42F7784F8697D13 ON report (comment_id)');
        $this->addSql('CREATE TABLE repost (id INT NOT NULL, original_post_id INT NOT NULL, reposted_by_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DD3446C5CD09ADDB ON repost (original_post_id)');
        $this->addSql('CREATE INDEX IDX_DD3446C5E8DE8338 ON repost (reposted_by_id)');
        $this->addSql('COMMENT ON COLUMN repost.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE reset_password_request (id INT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('COMMENT ON COLUMN reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE role_in_school (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, role_in_school_id INT NOT NULL, profile_id INT NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE INDEX IDX_8D93D64935E6CF91 ON "user" (role_in_school_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649CCFA12B8 ON "user" (profile_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F1C71C623 FOREIGN KEY (link_name_id) REFERENCES link_name (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B8650443B7 FOREIGN KEY (is_liked_by_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B84B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FFE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile_profile ADD CONSTRAINT FK_52E9749337A01814 FOREIGN KEY (profile_source) REFERENCES profile (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile_profile ADD CONSTRAINT FK_52E974932E45489B FOREIGN KEY (profile_target) REFERENCES profile (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F77844B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784F675F31B FOREIGN KEY (author_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE repost ADD CONSTRAINT FK_DD3446C5CD09ADDB FOREIGN KEY (original_post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE repost ADD CONSTRAINT FK_DD3446C5E8DE8338 FOREIGN KEY (reposted_by_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D64935E6CF91 FOREIGN KEY (role_in_school_id) REFERENCES role_in_school (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE grade_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE key_activation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE link_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE link_name_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE post_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE post_like_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE profile_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE report_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE repost_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reset_password_request_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE role_in_school_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C4B89032C');
        $this->addSql('ALTER TABLE link DROP CONSTRAINT FK_36AC99F1C71C623');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8DF675F31B');
        $this->addSql('ALTER TABLE post_like DROP CONSTRAINT FK_653627B8650443B7');
        $this->addSql('ALTER TABLE post_like DROP CONSTRAINT FK_653627B84B89032C');
        $this->addSql('ALTER TABLE profile DROP CONSTRAINT FK_8157AA0FFE19A1A8');
        $this->addSql('ALTER TABLE profile_profile DROP CONSTRAINT FK_52E9749337A01814');
        $this->addSql('ALTER TABLE profile_profile DROP CONSTRAINT FK_52E974932E45489B');
        $this->addSql('ALTER TABLE report DROP CONSTRAINT FK_C42F77844B89032C');
        $this->addSql('ALTER TABLE report DROP CONSTRAINT FK_C42F7784F675F31B');
        $this->addSql('ALTER TABLE report DROP CONSTRAINT FK_C42F7784F8697D13');
        $this->addSql('ALTER TABLE repost DROP CONSTRAINT FK_DD3446C5CD09ADDB');
        $this->addSql('ALTER TABLE repost DROP CONSTRAINT FK_DD3446C5E8DE8338');
        $this->addSql('ALTER TABLE reset_password_request DROP CONSTRAINT FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64935E6CF91');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649CCFA12B8');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE key_activation');
        $this->addSql('DROP TABLE link');
        $this->addSql('DROP TABLE link_name');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_like');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE profile_profile');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE repost');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE role_in_school');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
