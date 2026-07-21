<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260721125808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ca_member (position VARCHAR(50) NOT NULL, picture VARCHAR(255) DEFAULT NULL, id_user INT NOT NULL, PRIMARY KEY (id_user)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE coach (diploma_number VARCHAR(50) NOT NULL, speciality VARCHAR(50) DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, id_user INT NOT NULL, PRIMARY KEY (id_user)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE ca_member ADD CONSTRAINT FK_8B1DCB6F6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_3F596DCC6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ca_member DROP FOREIGN KEY FK_8B1DCB6F6B3CA4B');
        $this->addSql('ALTER TABLE coach DROP FOREIGN KEY FK_3F596DCC6B3CA4B');
        $this->addSql('DROP TABLE ca_member');
        $this->addSql('DROP TABLE coach');
    }
}
