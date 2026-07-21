<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260721141150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actuality (id_actuality INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, date_publication DATE NOT NULL, id_user INT NOT NULL, INDEX IDX_4093DDD86B3CA4B (id_user), PRIMARY KEY (id_actuality)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE event (id_event INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date DATE NOT NULL, type VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, id_user INT NOT NULL, INDEX IDX_3BAE0AA76B3CA4B (id_user), PRIMARY KEY (id_event)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE actuality ADD CONSTRAINT FK_4093DDD86B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA76B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actuality DROP FOREIGN KEY FK_4093DDD86B3CA4B');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA76B3CA4B');
        $this->addSql('DROP TABLE actuality');
        $this->addSql('DROP TABLE event');
    }
}
