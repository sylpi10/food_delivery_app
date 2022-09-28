<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220928120802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_order (menu_id INT NOT NULL, order_id INT NOT NULL, INDEX IDX_6485B0FFCCD7E912 (menu_id), INDEX IDX_6485B0FF8D9F6D38 (order_id), PRIMARY KEY(menu_id, order_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_order ADD CONSTRAINT FK_6485B0FFCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_order ADD CONSTRAINT FK_6485B0FF8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_order DROP FOREIGN KEY FK_6485B0FFCCD7E912');
        $this->addSql('ALTER TABLE menu_order DROP FOREIGN KEY FK_6485B0FF8D9F6D38');
        $this->addSql('DROP TABLE menu_order');
    }
}
