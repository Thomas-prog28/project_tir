<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260724085157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ca_member DROP picture');
        $this->addSql('ALTER TABLE coach DROP picture');
        $this->addSql('ALTER TABLE `member` DROP picture');
        $this->addSql('ALTER TABLE user ADD picture_name VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ca_member ADD picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE coach ADD picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE `member` ADD picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP picture_name, DROP updated_at');
    }
}
