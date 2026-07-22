<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260722103421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart (id_cart INT AUTO_INCREMENT NOT NULL, date_creation DATETIME NOT NULL, id_user INT NOT NULL, UNIQUE INDEX UNIQ_BA388B76B3CA4B (id_user), PRIMARY KEY (id_cart)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE cart_line (quantity INT NOT NULL, size VARCHAR(20) DEFAULT NULL, id_cart INT NOT NULL, id_product INT NOT NULL, INDEX IDX_3EF1B4CF808394B5 (id_cart), INDEX IDX_3EF1B4CFDD7ADDD (id_product), PRIMARY KEY (id_cart, id_product)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE customer_order (id_order INT AUTO_INCREMENT NOT NULL, date_order DATETIME NOT NULL, status_order VARCHAR(50) NOT NULL, total_amount NUMERIC(10, 2) NOT NULL, id_user INT NOT NULL, INDEX IDX_3B1CE6A36B3CA4B (id_user), PRIMARY KEY (id_order)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE order_line (quantity INT NOT NULL, size VARCHAR(20) DEFAULT NULL, unit_price NUMERIC(10, 2) NOT NULL, id_order INT NOT NULL, id_product INT NOT NULL, INDEX IDX_9CE58EE11BACD2A8 (id_order), INDEX IDX_9CE58EE1DD7ADDD (id_product), PRIMARY KEY (id_order, id_product)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE product (id_product INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price NUMERIC(10, 2) NOT NULL, picture VARCHAR(255) NOT NULL, PRIMARY KEY (id_product)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B76B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CF808394B5 FOREIGN KEY (id_cart) REFERENCES cart (id_cart)');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CFDD7ADDD FOREIGN KEY (id_product) REFERENCES product (id_product)');
        $this->addSql('ALTER TABLE customer_order ADD CONSTRAINT FK_3B1CE6A36B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE11BACD2A8 FOREIGN KEY (id_order) REFERENCES customer_order (id_order)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1DD7ADDD FOREIGN KEY (id_product) REFERENCES product (id_product)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B76B3CA4B');
        $this->addSql('ALTER TABLE cart_line DROP FOREIGN KEY FK_3EF1B4CF808394B5');
        $this->addSql('ALTER TABLE cart_line DROP FOREIGN KEY FK_3EF1B4CFDD7ADDD');
        $this->addSql('ALTER TABLE customer_order DROP FOREIGN KEY FK_3B1CE6A36B3CA4B');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE11BACD2A8');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1DD7ADDD');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_line');
        $this->addSql('DROP TABLE customer_order');
        $this->addSql('DROP TABLE order_line');
        $this->addSql('DROP TABLE product');
    }
}
