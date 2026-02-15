<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260125160825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, is_default TINYINT NOT NULL, created_at DATE NOT NULL, updated_at DATE DEFAULT NULL, house_hold_id INT NOT NULL, INDEX IDX_64C19C139C60054 (house_hold_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE expense (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(150) NOT NULL, amount NUMERIC(10, 2) NOT NULL, type VARCHAR(20) NOT NULL, date DATE NOT NULL, created_at DATE NOT NULL, updated_at DATE DEFAULT NULL, house_hold_id INT NOT NULL, user_id INT NOT NULL, category_id INT NOT NULL, sub_category_id INT DEFAULT NULL, INDEX IDX_2D3A8DA639C60054 (house_hold_id), INDEX IDX_2D3A8DA6A76ED395 (user_id), INDEX IDX_2D3A8DA612469DE2 (category_id), INDEX IDX_2D3A8DA6F7BFE87C (sub_category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE house_hold_user (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(30) NOT NULL, share_ratio DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL, house_hold_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3A29614939C60054 (house_hold_id), INDEX IDX_3A296149A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE household (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, type VARCHAR(255) NOT NULL, distribution_type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE income (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(150) NOT NULL, amount NUMERIC(10, 2) NOT NULL, date DATE NOT NULL, created_at DATE NOT NULL, updated_at DATE DEFAULT NULL, user_id INT NOT NULL, house_hold_id INT NOT NULL, INDEX IDX_3FA862D0A76ED395 (user_id), INDEX IDX_3FA862D039C60054 (house_hold_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE saving (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(100) NOT NULL, target_amount NUMERIC(10, 2) DEFAULT NULL, current_amount NUMERIC(10, 2) NOT NULL, created_at DATE NOT NULL, updated_at DATE DEFAULT NULL, house_hold_id INT NOT NULL, INDEX IDX_B9DC3D0C39C60054 (house_hold_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE sub_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, created_at DATE NOT NULL, updated_at DATE NOT NULL, category_id INT DEFAULT NULL, INDEX IDX_BCE3F79812469DE2 (category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C139C60054 FOREIGN KEY (house_hold_id) REFERENCES household (id)');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA639C60054 FOREIGN KEY (house_hold_id) REFERENCES household (id)');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA6F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id)');
        $this->addSql('ALTER TABLE house_hold_user ADD CONSTRAINT FK_3A29614939C60054 FOREIGN KEY (house_hold_id) REFERENCES household (id)');
        $this->addSql('ALTER TABLE house_hold_user ADD CONSTRAINT FK_3A296149A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE income ADD CONSTRAINT FK_3FA862D0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE income ADD CONSTRAINT FK_3FA862D039C60054 FOREIGN KEY (house_hold_id) REFERENCES household (id)');
        $this->addSql('ALTER TABLE saving ADD CONSTRAINT FK_B9DC3D0C39C60054 FOREIGN KEY (house_hold_id) REFERENCES household (id)');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F79812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C139C60054');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA639C60054');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA6A76ED395');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA612469DE2');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA6F7BFE87C');
        $this->addSql('ALTER TABLE house_hold_user DROP FOREIGN KEY FK_3A29614939C60054');
        $this->addSql('ALTER TABLE house_hold_user DROP FOREIGN KEY FK_3A296149A76ED395');
        $this->addSql('ALTER TABLE income DROP FOREIGN KEY FK_3FA862D0A76ED395');
        $this->addSql('ALTER TABLE income DROP FOREIGN KEY FK_3FA862D039C60054');
        $this->addSql('ALTER TABLE saving DROP FOREIGN KEY FK_B9DC3D0C39C60054');
        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F79812469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE expense');
        $this->addSql('DROP TABLE house_hold_user');
        $this->addSql('DROP TABLE household');
        $this->addSql('DROP TABLE income');
        $this->addSql('DROP TABLE saving');
        $this->addSql('DROP TABLE sub_category');
        $this->addSql('ALTER TABLE user DROP created_at, DROP updated_at');
    }
}
