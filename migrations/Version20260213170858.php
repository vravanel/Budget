<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213170858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE house_hold ADD owner_id BIGINT NOT NULL');
        $this->addSql('ALTER TABLE house_hold ADD CONSTRAINT FK_47A4232D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_47A4232D7E3C61F9 ON house_hold (owner_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY `FK_8D93D64924EBBD85`');
        $this->addSql('DROP INDEX UNIQ_8D93D64924EBBD85 ON user');
        $this->addSql('ALTER TABLE user DROP owned_house_hold_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE house_hold DROP FOREIGN KEY FK_47A4232D7E3C61F9');
        $this->addSql('DROP INDEX IDX_47A4232D7E3C61F9 ON house_hold');
        $this->addSql('ALTER TABLE house_hold DROP owner_id');
        $this->addSql('ALTER TABLE `user` ADD owned_house_hold_id BIGINT NOT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT `FK_8D93D64924EBBD85` FOREIGN KEY (owned_house_hold_id) REFERENCES house_hold (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64924EBBD85 ON `user` (owned_house_hold_id)');
    }
}
