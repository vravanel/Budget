<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213170115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, icon VARCHAR(50) DEFAULT NULL, color VARCHAR(7) NOT NULL, sort_order INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE expense (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, amount NUMERIC(10, 2) NOT NULL, date DATE NOT NULL, user_id BIGINT NOT NULL, house_hold_id BIGINT NOT NULL, category_id INT NOT NULL, INDEX IDX_2D3A8DA6A76ED395 (user_id), INDEX IDX_2D3A8DA639C60054 (house_hold_id), INDEX IDX_2D3A8DA612469DE2 (category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE house_hold (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, split_mode VARCHAR(255) DEFAULT \'FIFTY_FIFTY\' NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE house_hold_invitation (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, token VARCHAR(64) NOT NULL, status VARCHAR(255) NOT NULL, expires_at DATETIME NOT NULL, house_hold_id BIGINT NOT NULL, UNIQUE INDEX UNIQ_E124F3CD5F37A13B (token), INDEX IDX_E124F3CD39C60054 (house_hold_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE income (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, amount NUMERIC(10, 2) NOT NULL, date DATE NOT NULL, user_id BIGINT NOT NULL, house_hold_id BIGINT NOT NULL, INDEX IDX_3FA862D0A76ED395 (user_id), INDEX IDX_3FA862D039C60054 (house_hold_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE saving (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, amount NUMERIC(10, 2) NOT NULL, date DATE NOT NULL, goal_amount NUMERIC(10, 2) DEFAULT NULL, user_id BIGINT NOT NULL, house_hold_id BIGINT NOT NULL, INDEX IDX_B9DC3D0CA76ED395 (user_id), INDEX IDX_B9DC3D0C39C60054 (house_hold_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id BIGINT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, owned_house_hold_id BIGINT NOT NULL, house_hold_id BIGINT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64924EBBD85 (owned_house_hold_id), INDEX IDX_8D93D64939C60054 (house_hold_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA639C60054 FOREIGN KEY (house_hold_id) REFERENCES house_hold (id)');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE house_hold_invitation ADD CONSTRAINT FK_E124F3CD39C60054 FOREIGN KEY (house_hold_id) REFERENCES house_hold (id)');
        $this->addSql('ALTER TABLE income ADD CONSTRAINT FK_3FA862D0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE income ADD CONSTRAINT FK_3FA862D039C60054 FOREIGN KEY (house_hold_id) REFERENCES house_hold (id)');
        $this->addSql('ALTER TABLE saving ADD CONSTRAINT FK_B9DC3D0CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE saving ADD CONSTRAINT FK_B9DC3D0C39C60054 FOREIGN KEY (house_hold_id) REFERENCES house_hold (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64924EBBD85 FOREIGN KEY (owned_house_hold_id) REFERENCES house_hold (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64939C60054 FOREIGN KEY (house_hold_id) REFERENCES house_hold (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA6A76ED395');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA639C60054');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA612469DE2');
        $this->addSql('ALTER TABLE house_hold_invitation DROP FOREIGN KEY FK_E124F3CD39C60054');
        $this->addSql('ALTER TABLE income DROP FOREIGN KEY FK_3FA862D0A76ED395');
        $this->addSql('ALTER TABLE income DROP FOREIGN KEY FK_3FA862D039C60054');
        $this->addSql('ALTER TABLE saving DROP FOREIGN KEY FK_B9DC3D0CA76ED395');
        $this->addSql('ALTER TABLE saving DROP FOREIGN KEY FK_B9DC3D0C39C60054');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64924EBBD85');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64939C60054');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE expense');
        $this->addSql('DROP TABLE house_hold');
        $this->addSql('DROP TABLE house_hold_invitation');
        $this->addSql('DROP TABLE income');
        $this->addSql('DROP TABLE saving');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
