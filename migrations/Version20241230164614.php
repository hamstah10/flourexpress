<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241230164614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE treuepunkte (id INT AUTO_INCREMENT NOT NULL, sorte_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, datum DATETIME NOT NULL, menge VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2FEA12CFE54384C0 (sorte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE treuepunkte ADD CONSTRAINT FK_2FEA12CFE54384C0 FOREIGN KEY (sorte_id) REFERENCES sorte (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE treuepunkte DROP FOREIGN KEY FK_2FEA12CFE54384C0');
        $this->addSql('DROP TABLE treuepunkte');
    }
}
