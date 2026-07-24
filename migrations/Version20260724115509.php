<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260724115509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ca_member DROP FOREIGN KEY `FK_8B1DCB6F6B3CA4B`');
        $this->addSql('ALTER TABLE ca_member ADD CONSTRAINT FK_8B1DCB6F6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coach DROP FOREIGN KEY `FK_3F596DCC6B3CA4B`');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_3F596DCC6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `member` DROP FOREIGN KEY `FK_70E4FA786B3CA4B`');
        $this->addSql('ALTER TABLE `member` ADD CONSTRAINT FK_70E4FA786B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ca_member DROP FOREIGN KEY FK_8B1DCB6F6B3CA4B');
        $this->addSql('ALTER TABLE ca_member ADD CONSTRAINT `FK_8B1DCB6F6B3CA4B` FOREIGN KEY (id_user) REFERENCES user (id_user) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE coach DROP FOREIGN KEY FK_3F596DCC6B3CA4B');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT `FK_3F596DCC6B3CA4B` FOREIGN KEY (id_user) REFERENCES user (id_user) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE `member` DROP FOREIGN KEY FK_70E4FA786B3CA4B');
        $this->addSql('ALTER TABLE `member` ADD CONSTRAINT `FK_70E4FA786B3CA4B` FOREIGN KEY (id_user) REFERENCES user (id_user) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
