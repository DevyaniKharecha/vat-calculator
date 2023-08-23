<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230818100703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE calculation_history (
            id INT AUTO_INCREMENT NOT NULL, 
            amount DECIMAL(10, 2) NOT NULL, 
            vat_rate DECIMAL(5, 2) NOT NULL, 
            vat_amount DECIMAL(10, 2) NOT NULL, 
            total_amount DECIMAL(10, 2) NOT NULL, 
            inc_vat BOOLEAN NOT NULL, 
            PRIMARY KEY(id)
        ) ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE calculation_history');
    }
}
